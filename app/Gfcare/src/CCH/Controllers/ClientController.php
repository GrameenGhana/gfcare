<?php

namespace App\Gfcare\src\CCH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\CCH\Models\Role;

class ClientController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($this->getRoles());
    }
    
    public function getUsers(Request $request, $role) 
    {
        $r = Role::where('name',$role)->first();
        return response()->json($r->users());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, ['name' => 'required|max:255']);

        $role = Role::where('name',$request->name)->first();

        if(!$role) {
            $role = new Role();
            $role->name = $request->name;
            $role->team_id = $user->current_team_id;
            $role->is_editor = $request->is_editor;
            $role->save();
        }
        
        return $this->getRoles(); 
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $this->validate($request, [ 'name' => 'required|max:255', ]);
        
        if ($request->name != $role->name || $request->is_editor != $role->is_editor) {
            $role->updateUserModuleRole($request->name, $request->is_editor);
        }
        
        $role->fill(['name' => $request->name, 'is_editor'=>$request->is_editor])->save();
        return $role; 
    }

    public function destroy(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);         
        $role->updateUserModuleRole('invalid', 0);
        $role->delete();
        return $this->getRoles(); 
    }

    private function getRoles()
    {
        return Role::orderBy('name')->get();
    }
}
