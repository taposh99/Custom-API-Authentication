<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Carbon\Carbon;
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

            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,docx,doc,pptx',
        ]);

        // Handle image upload
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/meetings'), $imageName);
            $data['img'] = 'images/meetings/' . $imageName;
        }

        $meeting = Announcement::create($data);
        return response()->json(['data' => $meeting], 201);
    }

    
    public function update(Request $request, $id)
    {
        $meeting = Announcement::findOrFail($id);
        $meeting->update($request->all());
        return response()->json(['data' => $meeting]);
    }

    public function destroy($id)
    {
        $meeting = Announcement::findOrFail($id);
        $meeting->delete();
        return response()->json(null, 204);
    }
}
