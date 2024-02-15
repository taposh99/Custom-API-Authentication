<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MeetingAgenda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;



class EventController extends Controller
{


    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $events]);
    }


    public function MeetingAgenda($id)
    {
        $meetingsDetails = Event::with('meetingAgenda')->findOrFail($id);

        return response()->json([
            'success' => true,
            'meetingsDetailsData' => $meetingsDetails,
        ]);
    }



    public function showMeetingAgenda()
    {
        $meetingsDetails = Event::with('meetingAgenda')->get();

        return response()->json([
            'success' => true,
            'meetingsDetails' => $meetingsDetails,
        ]);
    }


    public function show($id)
    {
        $event = Event::with('meetingAgenda.subAgenda') // Include the meetingAgenda relationship
            ->findOrFail($id);

        return response()->json(['data' => $event]);
    }


    public function showID($id)
    {
        $event = Event::with('meetingAgenda.subAgenda')
            ->findOrFail($id);
        return response()->json(['data' => $event]);
    }





    public function store(Request $request)
    {
        $event = null;
    
        try {
            DB::beginTransaction();
    
            $data = $request->validate([
                'date' => 'nullable|date',
                'startTime' => 'nullable',
                'endTime' => 'nullable',
                'meetingTitle' => 'nullable|string',
                'meetingDiscussion' => 'nullable',
                'meetingLink' => 'nullable|string',
            ]);
    
            $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->format('Y-m-d');
            $event = Event::create($data);
    
            if (isset($request->agendaInfo) && is_array($request->agendaInfo)) {
                foreach ($request->agendaInfo as $agendaItem) {
                    $meetingAgenda = $event->meetingAgenda()->create([
                        'event_id' => $event->id,
                        'agendaTitle' => $agendaItem['agendaTitle'] ?? null,
                        'agendaDescription' => $agendaItem['agendaDescription'] ?? null,
                    ]);
    
                    if (isset($agendaItem['subagendaInfo']) && is_array($agendaItem['subagendaInfo'])) {
                        foreach ($agendaItem['subagendaInfo'] as $subagendaItem) {
                            $meetingAgenda->subAgenda()->create([
                                'meeting_agenda_id' => $meetingAgenda->id,
                                'subagendaTitle' => $subagendaItem['subagendaTitle'] ?? null,
                                'subagendaDescription' => $subagendaItem['subagendaDescription'] ?? null,
                            ]);
                        }
                    }
                }
            }
    
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // dd($exception);
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

    // public function upcomingMeetings()
    // {
    //     $upcomingMeetings = Event::with('meetingAgenda','meetingAgenda')->get();
    
    //     return response()->json(['upcoming_meetings' => $upcomingMeetings]);
    // }
    

    public function upcomingMeetings()
    {
        $upcomingMeetings = Event::with('meetingAgenda.subAgenda')->get();
    
        return response()->json(['upcoming_meetings' => $upcomingMeetings]);
    }
    
    public function previousMeetings()
    {
        $previousMeetings = Event::with('meetingAgenda.subAgenda')->get();
    
        return response()->json(['previous_meetings' => $previousMeetings]);
    }
    
    
}
