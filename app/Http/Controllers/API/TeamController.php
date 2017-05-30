<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Spark;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\TeamRepository;

class TeamController extends Controller
{
    /**
     * The team data repository.
     *
     * @var \App\Contracts\Repositories\TeamRepository
     */
    protected $teams;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Contracts\Repositories\TeamRepository  $teams
     * @return void
     */
    public function __construct(TeamRepository $teams)
    {
        $this->teams = $teams;

        $this->middleware('auth', ['except' => [
            'getInvitation',
        ]]);
    }

    /**
     * Get the team for the given ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function getTeam(Request $request, $teamId)
    {
        return $this->teams->getTeam($request->user(), $teamId);
    }

    /**
     * Get all of the teams for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllTeamsForUser(Request $request)
    {
        return $this->teams->getAllTeamsForUser($request->user());
    }

    /**
     * Get all of the available roles that may be assigned to team members.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamRoles()
    {
        $roles = [];

        foreach (Spark::roles() as $key => $value) {
            $roles[] = ['value' => $key, 'text' => $value];
        }

        return response()->json($roles);
    }
    
    /**
     * Get all of the available modules that may be assigned to teams.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamModules()
    {
           return response()->json(Spark::modules());
    }
    
    /**
     * Get the team location
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamFacilities(Request $request, $teamId)
    {
        $facs = array();
        $team = $this->teams->getTeam($request->user(), $teamId);
                
        // get facilities
        $facs = $team->facilities()->get();     

        return response()->json($facs);
    }

    /**
     * Get the team devices 
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamDevices(Request $request, $teamId)
    {
        $facs = array();
        $team = $this->teams->getTeam($request->user(), $teamId);
        $devices = $team->devices()->get();     
        return response()->json($devices);
    }

    /**
     * Get the team users 
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamProjectUsers(Request $request, $teamId)
    {
        $facs = array();
        $team = $this->teams->getTeam($request->user(), $teamId);
        $users = $team->projectusers()->get();     
        return response()->json($users);
    }
    
    /**
     * Get the team location
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamFacilitiesByLocation(Request $request, $teamId, $locationId)
    {
        $facs = array();
        $team = $this->teams->getTeam($request->user(), $teamId);
        
        // get locations including child locations
        $locs = $this->getParentIds($team, $locationId);
        
        // get facilities
        $facs = $team->facilities()->whereIn('location_id', $locs)->get();     

        return response()->json($facs);
    }
    
    private function getParentIds($team, $locationId, $parents=array()) 
    {
        $locs = $team->locations()->where('parent_id', $locationId)->lists('id')->all();
        
        if (sizeof($locs)) {
            foreach ($locs as $loc) {
                $parents = $this->getParentIds($team, $loc, $parents);
            }
        } 
            
        array_push($parents, $locationId);
        
        return $parents;
    }
    
    /**
     * Get the location types
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamLocationTypes()
    {
        $response = [
                     'geopolitical'=>Spark::locationTypes(), 
                     'facilities'=>Spark::facilityTypes(), 
                     'facilitygroups'=>Spark::facilityGroupTypes(),
                    ];
            
        return response()->json($response);
    }
       
    /**
     * Get the locations by their type
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamLocationsByType(Request $request, $teamId, $locationType)
    {
        $team = $this->teams->getTeam($request->user(), $teamId);
        $locations = $team->locations()->where('type',$locationType)->get();          
        return response()->json($locations);
    }

    /**
     * Get all of the pending invitations for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPendingInvitationsForUser(Request $request)
    {
        return $this->teams->getPendingInvitationsForUser($request->user());
    }

    /**
     * Get the invitation for the given code.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function getInvitation($code)
    {
        $model = config('auth.providers.users.model');

        $model = get_class((new $model)->invitations()
                    ->getQuery()->getModel());

        $invitation = (new $model)->with('team.owner')
                    ->where('token', $code)->firstOrFail();

        if ($invitation->isExpired()) {
            $invitation->delete();

            abort(404);
        }

        $invitation->team->setVisible(['name', 'owner']);

        $invitation->team->owner->setVisible(['name']);

        return $invitation;
    }
}
