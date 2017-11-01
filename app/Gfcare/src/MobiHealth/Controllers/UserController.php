<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\AppUser;
use App\GfCare\src\MobiHealth\Models\MobiUser;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $users = MobiUser::all();
        return response()->json($users);
    }

    public function showTunza(Request $request, $teamId=null)
    {
        $users = AppUser::where('app_data','tz')->get();
        return response()->json($users);
    }

     public function showKijana(Request $request, $teamId=null)
    {
        $users = AppUser::where('app_data','kj')->get();
        return response()->json($users);
    }

    public function communityUser(Request $request,$userId){
         
         $users = AppUser::where('uuid',$userId)->where('app_data',$request->app_data)->get();
        Log::info("Response -> " . $users);
         if($users==null)
         {
              return response()->json(['error' => 'No user available'], 401);
         }
         else
         return response()->json($users);
    }


    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request,['user_id'=>'required|exists:users,id','role'=>'required']);

        $cu = \App\User::where('id',$request->user_id)->first();

        if($cu) {
            $cu->joinModuleById($user->current_team_id, 
                               $user->current_module_id, 
                               $request->role, false);
            
            return MobiUser::find($cu->id);
            
        } else {
            return response()->json(['user_id' => ['Cannot find user. Please add the user from the Project settings.']], 422);
        }
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u = MobiUser::findOrFail($userId);
        $this->validate($request, ['role' => 'required']);
        $u->modules()->updateExistingPivot($user->current_module_id, ['role' => $request->role, 'editor'=>false]);
        return $u; 
    }

     

    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $cu = MobiUser::findOrFail($userId); 
        $cu->modules()->newPivotStatementForId($user->current_module_id)->where('module_id', $user->current_module_id)->delete();
    }
}
