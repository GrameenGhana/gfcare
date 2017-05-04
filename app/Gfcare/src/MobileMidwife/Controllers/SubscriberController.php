<?php

namespace App\Gfcare\src\MobileMidwife\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Spark;
use App\GfCare\src\MobileMidwife\Models\Subscriber;
use App\GfCare\src\MobileMidwife\Models\Program;
use App\GfCare\src\MobileMidwife\Models\Subscription;


class SubscriberController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $clients = Subscriber::all();
        return response()->json($clients);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                'name' => 'required|max:255',
                                'module_id' => 'exists:modules,module_id',
                                'team_id' => 'exists:teams,id',
                                'user_id' => 'required|exists:users,id',
                                'program_id' => 'required|exists:mod_mm_programs,id',
                                'start_week' => 'required|numeric',
                                'name' => 'required|string|max:255',
                                'phone' => 'required|string|max:20',
                                'dob' => 'required|date',
                                'gender'=> 'required|in:male,female',
                                'language'=>'required|string',
                                'channel' => 'required|in:voice,sms,both',
                                'long' => 'string',
                                'lat' => 'string',
                                'education' => 'string',
                                'location' => 'in:urban,rural',
                                'client_type' => 'in:pregnant woman,mother,child,other',
                        ]);

        $client = Subscriber::whereRaw('name=? and program_id=? and channel=?',array($request->name,$request->program_id,$request->channel))->first();

        if(!$client) {
            $client = new Subscriber();
            $client->team_id = (isset($request->team_id)) ? $request->team_id : $user->current_team_id;
            $client->module_id = (isset($request->module_id)) ? $request->module_id : $user->current_module_id;
            $client->program_id = $request->program_id;
            $client->start_week = $this->getValidStartWeek($request->start_week, $request->program_id);
            $client->name = $request->name;
            $client->phone = $request->phone;
            $client->dob = date('Y-m-d', strtotime($request->dob));
            $client->gender = $request->gender;
            $client->language = $request->language;
            $client->channel = $request->channel;
            $client->lat = (isset($request->lat)) ? $request->lat : Spark::defaultLatitude();
            $client->long = (isset($request->long)) ?  $request->long : Spark::defaultLongitude();
            $client->education = (isset($request->education)) ? $request->education : '';
            $client->location = (isset($request->location)) ? $request->location : '';
            $client->client_type = (isset($request->client_type)) ? $request->client_type : '';

            $client->registered_by = $request->user_id; 
            $client->modified_by = $user->id;
            $client->save();
            
            // Sign up for program
            Subscription::subscribe($client);
        }
        
        return response()->json($client); 
    }
    
    private function getValidStartWeek($week, $programId)
    {
        $program = Program::find($programId);
        return $program->validateWeek($week);
    }

    public function update(Request $request, $clientId)
    {
        $user = $request->user();
        $client = Subscriber::findOrFail($clientId);
        $this->validate($request, [
                                   'name' => 'required|max:255',
                                   'user_id' => 'required|exists:users,id',
                                   'registered' => 'required|in:0,1',
                                  ]);

            $client->name = $request->name;
            $client->team_id = $user->current_team_id;
            $client->user_id = $request->user_id;
            $client->registered = $request->registered;
            $client->registration_date = ($request->registered) ? date('Y-m-d') : ''; 
            $client->modified_by = $user->id;
            $client->save();

        return $client; 
    }

    public function destroy(Request $request, $clientId)
    {
        $client = Subscriber::findOrFail($clientId); 
        $client->delete();
        return $client; 
    }
}
