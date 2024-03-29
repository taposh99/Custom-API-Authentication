<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MeetingMinute;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeetingMinuteController extends Controller
{

    
    public function getMinutes()
    {
        $Minutes = MeetingMinute::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $Minutes]);
    }

    public function storeMeetingMinutes(Request $request): JsonResponse
    {
        try {
            MeetingMinute::create([
                'event_id' => $request->meetingId,
                'notes' => $request->meetingMinutes
            ]);

        } catch (Exception $exception) {
            return sendErrorResponse('Something Went Wrong'. $exception->getMessage());
        }
        return sendSuccessResponse('Notes Added Successfully');
    }
}
