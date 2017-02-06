<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Spark;

use Tymon\JWTAuth\JWTAuth;


class LoginController extends Controller
{
    private $jwtauth;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
    }


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

        $credentials = $request->only('email', 'password');
        $token = null;

        try {
            $token = $this->jwtauth->attempt($credentials);
            if (!$token) {
                return response()->json(['error'=>'invalid_email_or_password'], 422);
            }
        
            Auth::attempt($credentials);
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

        } catch (JWTAuthException $e) {
            return response()->json(['error'=>'failed_to_create_token'], 500);
        }

        return response()->json(['token'=>$token, 'user'=>$user]);
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
