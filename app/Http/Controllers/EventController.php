<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MeetingAgenda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class EventController extends Controller
{
    // public function index()
    // {
    //     $events = Event::all();
    //     return response()->json(['data' => $events]);
    // }

    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $events]);
    }


    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['data' => $event]);
    }

    public function showID($id)
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
            'date' => 'nullable|date',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'meetingTitle' => 'nullable|string',
            'meetingDiscussion' => 'nullable',
            'meetingLink' => 'nullable|string',
        ]);

        $agenda = $request->validate([
            'agendaTitle' => 'nullable|string',
            'agendaDescription' => 'nullable',
            'agendaDocument' => 'nullable|string',
        ]);


        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->format('Y-m-d');
        $event = Event::create($data);

        foreach ($request->agendaInfo as $agendaItem) {
            // dd($agendaItem);
                // Create a new MeetingAgenda instance and associate it with the event
                $event->meetingAgenda()->create([
                    'agendaTitle' => $agendaItem['agendaTitle'],
                    'agendaDescription' => $agendaItem['agendaDescription'],
                    'agendaDocument' => $agendaItem['agendaDocument']
                ]);
            }

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

    // upcomingMeetings api
    public function upcomingMeetings()
    {
        $currentDate = Carbon::now()->toDateString();

        $upcomingMeetings = Event::where('date', '>=', $currentDate)
            ->orderBy('date', 'desc')->get();


        return response()->json(['upcoming_meetings' => $upcomingMeetings]);
    }


    // previousMeetings api
    public function previousMeetings()
    {
        $currentDate = Carbon::now()->toDateString();

        $previousMeetings = Event::where('date', '<', $currentDate)
            ->orderBy('date', 'desc')->get();


        return response()->json(['previous_meetings' => $previousMeetings]);
    }
}
