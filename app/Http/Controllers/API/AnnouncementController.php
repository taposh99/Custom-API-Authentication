<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $meetings = Announcement::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $meetings]);
    }
    

    public function show($id)
    {
        $meeting = Announcement::findOrFail($id);
        return response()->json(['data' => $meeting]);
    }
   

public function store(Request $request)
{
    $data = $request->validate([
        'announcementTitle' => 'nullable|string',
        'description' => 'nullable|string',
        'img' => 'nullable|file|mimes:jpeg,png,pdf', // Accepts both images and PDFs
        'documents' => 'nullable|array',
        'documents.*' => 'file|mimes:pdf', // Only accepts PDF files for documents
    ]);

    // Handle file upload for 'img' field (either image or PDF)
    if ($request->hasFile('img')) {
        $file = $request->file('img');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/meetings'), $fileName);
        $data['img'] = 'images/meetings/' . $fileName;
    }

    // Handle PDF uploads for 'documents' field
    if ($request->hasFile('documents')) {
        $pdfs = [];

        foreach ($request->file('documents') as $pdf) {
            $pdfName = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('images/meetings'), $pdfName);
            $pdfs[] = 'images/meetings/' . $pdfName;
        }

        $data['documents'] = $pdfs;
    }

    $meeting = Announcement::create($data);
    return response()->json(['data' => $meeting], 201);
}




    public function update(Request $request, $id)
{
    $meeting = Announcement::findOrFail($id);

    $data = $request->validate([
        'announcementTitle' => 'nullable|string',
        'description' => 'nullable|string',
        'img' => 'nullable|file|mimes:jpeg,png,pdf', // Accepts both images and PDFs
        'documents' => 'nullable|array',
        'documents.*' => 'file|mimes:pdf', // Only accepts PDF files for documents
    ]);

    // Handle file upload for 'img' field (either image or PDF)
    if ($request->hasFile('img')) {
        $file = $request->file('img');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/meetings'), $fileName);
        $data['img'] = 'images/meetings/' . $fileName;
    }

    // Handle PDF uploads for 'documents' field
    if ($request->hasFile('documents')) {
        $pdfs = [];

        foreach ($request->file('documents') as $pdf) {
            $pdfName = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('images/meetings'), $pdfName);
            $pdfs[] = 'images/meetings/' . $pdfName;
        }

        $data['documents'] = $pdfs;
    }

    $meeting->update($data);

    return response()->json(['data' => $meeting]);
}

    
    

    public function destroy($id)
    {
        $meeting = Announcement::findOrFail($id);
        $meeting->delete();
        return response()->json(null, 204);
    }
}
