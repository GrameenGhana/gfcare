<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use App\GfCare\src\MobiHealth\Models\Meeting;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;


class MeetingController extends Controller
{
    //

    public function show(Request $request)
    {
        $meetings = Meeting::all();
        return response()->json($meetings);
    }

     
    public function meeting(Request $request,$userId)
    {

    	$meetings = Meeting::where('meeting_by',$userId)->get();
    	 //Log::info($meetings);
    	return response()->json($meetings);
    }


    public function store(Request $request)
    {
    	 $user = $request->user();
        
         $meeting = new Meeting();
         $appuser = \App\User::where('id',$request->meeting_by)->first();
          
         
         $meeting->name = $request->name;
         $meeting->team_id = $user->current_team_id;
         $meeting->meeting_by = $request->meeting_by;
         $meeting->topic = $request->topic;
         $meeting->team_id = $user->current_team_id;
         $meeting->organised_by = $appuser->name;
         $meeting->start_time = $request->start_time;
         $meeting->end_time = $request->end_time;

         $meeting->save();
         return response()->json($meeting);

    }


}
