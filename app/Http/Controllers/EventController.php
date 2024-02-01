<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json(['data' => $events]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['data' => $event]);
    }

    // public function store(Request $request)
    // {
    //     $meeting = Meeting::create($request->all());
    //     return response()->json(['data' => $meeting], 201);
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|string',
            'date' => 'required',
            'startTime' => 'required',
            'meetingTopic' => 'required|string',
            'meetingCreator' => 'required|string',
            'meetingDiscussion' => 'required|string',
            'zoomLink' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image type and size
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/event'), $imageName);
            $data['image'] = 'images/meetings/' . $imageName;
        }

        $event = Event::create($data);
        return response()->json(['data' => $event], 201);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json(['data' => $event]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }
}