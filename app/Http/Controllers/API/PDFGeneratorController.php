<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MeetingMinute;
use App\Models\MeetingMinutesPDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PDFGeneratorController extends Controller
{
    
    public function indexMeetingMinute()
    {
        $meetingsPdf = MeetingMinutesPDF::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $meetingsPdf]);
    }
    public function generatePdf(Request $request): JsonResponse
    {
        
        
        try {
            DB::beginTransaction();
            $meetingNotes = MeetingMinute::with('event')->whereEvent_id($request->meetingId)->get();
            $data = ['meetingNotes' => $meetingNotes];
            $pdf = PDF::loadView('Notes.notes', $data);
            $uniqueName = str_replace(' ', ' ', $meetingNotes->first()->event->meetingTitle) . '.pdf';
            $pdfPath = 'meeting_notes/' . $uniqueName;
            if (!File::isDirectory(public_path('meeting_notes'))) {
                File::makeDirectory(public_path('meeting_notes'), 0755, true); // true for recursive creation
            }
            $pdf->save(public_path($pdfPath));
            $this->savePDFPathToDatabase($uniqueName, $request->meetingId);
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            return sendErrorResponse('Something Went Wrong'. $exception->getMessage());
        }

        return sendSuccessResponse('Pdf Generated Successfully');
    }


    protected function savePDFPathToDatabase($pdf, $meetingId): void
    {
        MeetingMinutesPDF::create([
            'event_id' => $meetingId,
            'pdf' => $pdf
        ]);

        $meetingMinutes = MeetingMinute::whereEvent_id($meetingId)->get();
        foreach ($meetingMinutes as $note) {
            $note->delete();
        }
    }
}
