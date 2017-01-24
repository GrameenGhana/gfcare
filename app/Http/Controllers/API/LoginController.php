<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Spark;

class LoginController extends Controller
{
	/**
	 * Get the current user of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        $module = $request->module;

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Spark::user();
            $user->currentTeam;
            
            $user->projects = $this->getProjects($user, $module); 

            if ($user->projects==null) {
                return response()->json(['error' => 'No access to module'], 401);
            }

            unset($user->teams);
            unset($user->modules);
            unset($user->current_module_id);
            unset($user->current_team_id);
            unset($user->updated_at);
            unset($user->created_at);

            return response()->json($user);
        }

        return response()->json(['error' => 'invalid_credentials'], 401);
    }


    private function getProjects($user, $module)
    {
        $projects = array();

        foreach($user->modules as $m) {
            if ($m->module_id == $module) {
                $p = $this->getTeam($user, $m->team_id);
                foreach($p as $i) { array_push($projects, $i); }
            }
        }  

        return (sizeof($projects)>0) ? $projects : null;
    }

    private function getTeam($user, $id) {
        $data = array();
        foreach($user->teams as $t) {
            if ($t->id == $id) {
                array_push($data, $t);
            }
        }
        return $data;
    }
}
