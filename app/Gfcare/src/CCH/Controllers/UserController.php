<?php

namespace App\Gfcare\src\CCH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\GfCare\src\CCH\Models\CCHUser;
use App\GfCare\src\CCH\Models\Role;


class UserController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $users = CCHUser::all();
        return response()->json($users);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request,['user_id'=>'required|exists:users,id','role'=>'required']);

        $cu = \App\User::where('id',$request->user_id)->first();

        if($cu) {
            // Add to module
            $r = Role::where('name',$request->role)->first();

            $cu->joinModuleById($user->current_team_id, 
                                $user->current_module_id, 
                                $r->name,
                                $r->is_editor);
            
            return CCHUser::find($cu->id);
            
        } else {
            return response()->json(['user_id' => ['Cannot find user. Please add the user from the Project settings.']], 422);
        }
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u = CCHUser::findOrFail($userId);
        $this->validate($request, [ 'role' => 'required']);
        $r = Role::where('name',$request->role)->first();
        $u->modules()->updateExistingPivot($user->current_module_id, ['role' => $r->name, 'editor'=>$r->is_editor]);
        return $u; 
    }

    
    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $cu = CCHUser::findOrFail($userId); 
        $cu->modules()->newPivotStatementForId($user->current_module_id)->where('module_id', $user->current_module_id)->delete();
    }
}
