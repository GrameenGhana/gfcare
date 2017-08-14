<?php

namespace App\Gfcare\src\MobileMidwife\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\MobileMidwife\Models\Campaign;
use App\GfCare\src\MobileMidwife\Models\Program;


class ServiceController extends Controller
{
    public function showCampaigns(Request $request, $teamId=null)
    {
        $users = Campaign::all();
        return response()->json($users);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        //$this->validate($request,['user_id'=>'required|exists:users,id','role'=>'required']);

        $cu = \App\User::where('id',$request->user_id)->first();

        if($cu) {
            $cu->joinModuleById($user->current_team_id, 
                               $user->current_module_id, 
                               $request->role, false);
            
            return MobileMidwifeUser::find($cu->id);




            
        } else {
            return response()->json(['user_id' => ['Cannot find user. Please add the user from the Project settings.']], 422);
        }
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u = MobileMidwifeUser::findOrFail($userId);
        $this->validate($request, ['role' => 'required']);
        $u->modules()->updateExistingPivot($user->current_module_id, ['role' => $request->role, 'editor'=>false]);
        return $u; 
    }


    public function storeCampaign(Request $request)
    {
         $user = $request->user();
         
         $campaign = new Campaign();

        Log::info("save campaign ");
         
         $campaign->team_id = $user->current_team_id;
         $campaign->name = $request->name;
         $campaign->description = $request->description;
         $campaign->start_date = $request->start_date;
         $campaign->end_date = $request->end_date;
         $campaign->modified_by =$user->id;
         
         $campaign->save();

         return response()->json($campaign);
    }

    public function storeProgram(Request $request)
    {
         $user = $request->user();
         
         $program = new Program();

        Log::info("save program ");
         
         $program->team_id = $user->current_team_id;
         $program->name = $request->name;
         $program->campaign_id = $request->campaign;
         $program->channels = $request->channel;
         $program->start_week = $request->start_week;
         $program->end_week = $request->end_week;
         $program->modified_by =$user->id;
         
         $program->save();

         return response()->json($program);
    }

    public function showPrograms(Request $request)
    {
        $programs = Program::all();
        return response()->json($programs);
    }

    
    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $cu = MobileMidwifeUser::findOrFail($userId); 
        $cu->modules()->newPivotStatementForId($user->current_module_id)->where('module_id', $user->current_module_id)->delete();
    }
}
