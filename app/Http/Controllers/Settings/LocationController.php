<?php

namespace App\Http\Controllers\Settings;

use Exception;
use App\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\TeamRepository;

class LocationController extends Controller
{
    /**
     * The team repository instance.
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
        $this->middleware('auth');
    }

    /**
     * Create new location.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function storeLocation(Request $request, $teamId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateLocation($request, $team);        
        $team->addLocation($request->parent_id, $request->type, $request->name, $request->level);
        return $team->fresh($this->teamWith);
    }
    
    /**
     * Update the team's location information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function updateLocation(Request $request, $teamId, $locationId)
    {
        $user = $request->user();

        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateLocation($request, $team, true);
        
        $location = $team->locations()->where('id', $locationId)->first();

        if ($location) {
            $location->fill([
                            'name' => $request->name,
                            'type' => $request->type,
                            'level' => $request->level,
                            'parent_id' => $request->parent_id
                            ])->save();
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Destroy the given location.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function destroyLocation(Request $request, $teamId, $locationId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);
        
        $location = $team->locations()->where('id', $locationId)->first();

        if ($location) {
            if ($location->isParent() || $location->hasFacilities()) {
                return response()->json(
                    ['error' => ['Cannot remove location. Remove all associated locations and facilities first']], 422
                );
            } else {
                $location->delete();   
            }
        } else {
            return response()->json(['error' => ['This location does not exist']], 422);
        }
        
        return $team->fresh($this->teamWith);
    }
    
    /**
     * Create new facility.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function storeFacility(Request $request, $teamId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateFacility($request, $team);        

        $fac = $team->facilities()->whereRaw("location_id=? and type=? and LOWER(name)=?",
                    array($request->location_id,$request->type,strtolower($request->name)))->first();

        if (! $fac) {
            $fac = $team->facilities()->create(['location_id' => $request->location_id, 
                                               'type'=>$request->type, 
                                               'name'=>$request->name, 
                                               'contact'=>$request->contact,
                                               'address'=>$request->address,
                                               'email'=>$request->email,
                                               'phonenumber'=>$request->phonenumber,
                                               'longitude'=>$request->longitude,
                                               'latitude'=>$request->latitude
                                              ]);
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Update the team's facility information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $facilityId
     * @return \Illuminate\Http\Response
     */
    public function updateFacility(Request $request, $teamId, $facilityId)
    {
        $user = $request->user();

        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateFacility($request, $team, true);
        
        $fac = $team->facilities()->where('id', $facilityId)->first();

        if ($fac) {
            $fac->fill([
                       'location_id' => $request->location_id, 
                       'type'=>$request->type, 
                       'name'=>$request->name, 
                       'contact'=>$request->contact,
                       'address'=>$request->address,
                       'email'=>$request->email,
                       'phonenumber'=>$request->phonenumber,
                       'longitude'=>$request->longitude,
                       'latitude'=>$request->latitude
                    ])->save();
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Destroy the given facility.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $facilityId
     * @return \Illuminate\Http\Response
     */
    public function destroyFacility(Request $request, $teamId, $facilityId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);
        
        $fac = $team->facilities()->where('id', $facilityId)->first();

        if ($fac) {
            $fac->removeFromGroups();
            $fac->delete();   
        } else {
            return response()->json(['error' => ['This facility does not exist']], 422);
        }
        
        return $team->fresh($this->teamWith);
    }
    
    /**
     * Create new facility group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function storeFacilityGroup(Request $request, $teamId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateFacilityGroup($request, $team);        

        $fac = $team->facilitygroups()->whereRaw("type=? and LOWER(name)=?",
                    array($request->type,strtolower($request->name)))->first();

        if (! $fac) {
            $facIds = "";
            foreach($request->facilities as $f) {  $facIds += $f['id'] . ','; }
            $fac = $team->facilitygroups()->create([
                                               'type'=>$request->type, 
                                               'name'=>$request->name, 
                                               'facilities'=>$facIds,]);
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Update the team's facility group information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $facilityGroupId
     * @return \Illuminate\Http\Response
     */
    public function updateFacilityGroup(Request $request, $teamId, $facilityGroupId)
    {
        $user = $request->user();

        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        $this->validateFacilityGroup($request, $team, true);
        
        $fac = $team->facilitygroups()->where('id', $facilityGroupId)->first();

        if ($fac) {
            $fac->fill([
                       'type'=>$request->type, 
                       'name'=>$request->name, 
                       'facilities'=>$request->facilities,
                    ])->save();
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Destroy the given facility group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $facilityGroupId
     * @return \Illuminate\Http\Response
     */
    public function destroyFacilityGroup(Request $request, $teamId, $facilityGroupId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);
        
        $fac = $team->facilities()->where('id', $facilityGroupId)->first();

        if ($fac) {
            $fac->delete();   
        } else {
            return response()->json(['error' => ['This facility group does not exist']], 422);
        }
        
        return $team->fresh($this->teamWith);
    }
    
    
    /**
     * Validate a location request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teams\Team $team
     * @param  boolean $update
     * @return void
     */
    protected function validateLocation(Request $request, $team, $update=false)
    {
        $rules = [
                'parent_id' => 'location_parent',
                'type' => 'required|max:255',
                'level' => 'required|numeric',
                'name' => 'required|max:255',
        ];
        
        if (!$update) { // make sure location is unique
            $params = 'parent_id,'.$request->parent_id.',type,'.$request->type.',level,'.$request->level;
            $rules['name'] = 'unique:locations,name,NULL,id,'.$params;
        }
        
        $this->validate($request, $rules, ['unique' => 'This location already exists.']); 
    }
    
    /**
     * Validate a facility request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teams\Team $team
     * @param  boolean $update
     * @return void
     */
    protected function validateFacility(Request $request, $team, $update=false)
    {
        $rules = [
                'location_id' => 'location_parent',
                'type' => 'required|max:255',
                'name' => 'required|max:255',
                'email' => 'email',
                'longitude' => 'regex:(\-?\d+(\.\d+)?)',
                'latitude' => 'regex:(\-?\d+(\.\d+)?)'
        ];
        
        if (!$update) { // make sure facility is unique
            $params = 'location_id,'.$request->location_id.',type,'.$request->type.',name,'.$request->name;
            $rules['name'] = 'unique:locations_facility,name,NULL,id,'.$params;
        }
        
        $this->validate($request, $rules, ['unique' => 'This facility already exists.']);
    }
    
    /**
     * Validate a facility group request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teams\Team $team
     * @param  boolean $update
     * @return void
     */
    protected function validateFacilityGroup(Request $request, $team, $update=false)
    {
        $rules = [
                'type' => 'required|max:255',
                'name' => 'required|max:255',
                'facilities' => 'required|max:255',
        ];
        
        if (!$update) { // make sure facility group is unique
            $params = 'team_id,'.$team->id.',type,'.$request->type.',name,'.$request->name;
            $rules['name'] = 'unique:locations_facilitygroups,name,NULL,id,'.$params;
        }
        
        $this->validate($request, $rules, ['unique' => 'This facility group already exists.']);  
    }
}
