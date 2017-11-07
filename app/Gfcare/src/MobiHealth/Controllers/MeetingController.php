<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use App\GfCare\src\MobiHealth\Models\Meeting;
use App\GfCare\src\MobiHealth\Models\Attendance;
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
         Log::info($request->meeting_by);
        
         $meeting = new Meeting();
         $appuser = \App\User::where('id',$request->meeting_by)->first();
           Log::info($request->name);
            Log::info($appuser->name);

             Log::info($user->current_team_id);
              Log::info($request->start_time);
               Log::info($request->end_time);
                Log::info($request->meeting_by);
         
         $meeting->name = $request->name;
         $meeting->team_id = $user->current_team_id;
         $meeting->meeting_by = $request->meeting_by;
         $meeting->topic = $request->topic;
         //$meeting->team_id = $user->current_team_id;
         $meeting->organised_by = $appuser->name;
         $meeting->start_time = $request->start_time;
         $meeting->end_time = $request->end_time;

         $meeting->save();
         return response()->json($meeting);

    }


    public function attendance(Request $request)
    {
          $data=$request->json()->all();
           $user = $request->user();
          Log::info($request->json()->all());

           $meeting = $data['meeting'];
           $attendance = $data['attendance'];
          
          
           
           foreach($attendance as $attend){
              
             Log::info($attend['id']);
             $att  = new Attendance(); 
              
             $att->team_id = $user->current_team_id;
             $att->meeting_id = $meeting;
             $att->person_id = $attend['id'];

             $att->save();

           }

          return response()->json('ok');

    }


}
