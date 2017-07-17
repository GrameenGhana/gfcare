<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Teams\ProjectUser;
use App\Teams\UserInfo;
use App\Teams\UserFacility;
use App\Teams\Device;


class ProjectUserController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $users = ProjectUser::all();
        return response()->json($users);
    }
    
    public function store(Request $request)
    {
       
        Log::info('This is some useful information.');

       $user = $request->user();



        //$this->validate($request, ['email' => 'required|email',
                                   //'name' => 'required|max:255',
                                  // 'password'=> 'required|min:6',
                                 //  'gender' => 'required',
                                 //  'role' => 'required',
                                  // 'title' => 'required',
                                  // 'phone_number' => 'digits_between:7,16',
                                 //  'primary_facility' => 'required',
                                 //  'status'=> 'required',
                                 // ]
                              //  );  

        $cu = ProjectUser::where('email',$request->email)->first();
           
        if(!$cu) {
            // Add user
            $u = new ProjectUser();
            $u->name = $request->name;
            $u->email = $request->email;
            $u->password = Hash::make($request->password);
            $u->current_team_id = $user->current_team_id;
            $u->current_module_id = 0;
            $u->phone_country_code = \App\Spark::defaultPhoneCode();
            $u->phone_number = $request->phone_number;
            $u->user_type = 'User';
            $u->save();

            // add to team          
            $u->joinTeamById($user->current_team->id,'project');

            // Add userinfo
            $ui = new UserInfo();
            $ui->team_id = $u->current_team_id;
            $ui->user_id = $u->id;
            $ui->gender = $request->gender;
            $ui->title = $request->title;
            $ui->ischn = $request->ischn;
            $ui->status = $request->status;
            $ui->modified_by = $user->id;
            $ui->save();
                    
            // Devices
            if ($request->device) {
                $device = Device::find($request->device);
                $device->user_id = $u->id;
                $device->facility_id = $request->primary_facility;
                $device->status = 'active';
                $device->modified_by = $user->id;
                $device->save();
            }
            
            $this->addUpdateFacilities($request, $user, $u);

               // Add user to Oppia user's list
            $uname = $request->name;
            
            
            $postdata = array('username' => $request->email,
                'password' => $request->password,
                'passwordagain' => $request->password,
                'email' =>$request->email,
                'firstname'=> substr($uname,0,strpos($uname,' ')),
                'lastname' => substr($uname,strpos($uname,' ')));
            
            Log::info('hello' .$postdata['firstname'] . " " .$postdata['lastname']);
            $url = 'http://localhost/cb/content/lc/api/v1/register/';
           // $url = 'http://188.166.30.140/cb/content/lc/api/v1/register/';
                                                                           
            $data_string = json_encode($postdata);                                                                                                                                                                          
            $ch = curl_init( $url);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));                                                                                                                   
                                                                                                                     
            $result = curl_exec($ch);

             Log::info("Response -> " . $result);
            return ProjectUser::find($u->id);
            
        } else {
            if ($cu->isModuleUser()) {
                return response()->json(['email' => ['User already exits.']], 422);
            } else {
                return response()->json(['email' => ['Can\'t add a system user. Please do that from the Project team tab.']], 422);
            }
        }
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u= ProjectUser::findOrFail($userId);
        
      //  $this->validate($request, ['email' => 'required|email',
                          // 'name' => 'required|max:255',
                       //   'current_password' => 'required_with:password|min:6',
                         //  'password' => 'min:6',
                          // 'gender' => 'required',
                          // 'role' => 'required',
                          // 'title' => 'required',
                          // 'phone_number' => 'digits_between:7,16',
                         //  'primary_facility' => 'required',
                         //  'status'=> 'required',
                         // ]
                     //   );
        
        if ($request->password<>'') {
            if (! Hash::check($request->current_password, $u->password)) {
                return response()->json(
                    ['current_password' => ['The current password you provided is incorrect.']], 422);
            }
        }
        
        // update user
        $u->name = $request->name;
        $u->email = $request->email;
        $u->password = Hash::make($request->password);
        $u->phone_number = $request->phone_number;
        $u->save();
        
        $u->teams()->updateExistingPivot($user->current_team_id, ['role' => $request->role]);

        // user info
        $ui = $u->info;
        $ui->gender = $request->gender;
        $ui->title = $request->title;
        $ui->ischn = $request->ischn;
        $ui->status = $request->status;
        $ui->modified_by = $user->id;
        $ui->save();
        
        // Devices
        if ($request->device) {
            // release any old ones
            $this->releaseDevice($u);
            
            // Update new one
            $device = Device::find($request->device);
            $device->user_id = $u->id;
            $device->facility_id = $request->primary_facility;
            $device->status = 'active';
            $device->modified_by = $user->id;
            $device->save();
        }
        
        $this->addUpdateFacilities($request, $user, $u);
        
        return $u; 
    }

    
    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $cu = ProjectUser::findOrFail($userId); 
        
        $cu->modules()->newPivotStatementForId($user->current_module_id)->where('module_id', $user->current_module_id)->delete();

        $ui = UserInfo::where('user_id',$cu->id)->first();
        if ($ui) { $ui->delete(); };
        
        $uf = UserFacility::where('user_id',$cu->id)->pluck('id');
        if ($uf) { UserFacility::destroy($uf); }
        
        $this->releaseDevice($cu);
  
        if (!$cu->hasModules()) { $cu->delete(); }
    }
    
    private function releaseDevice($cu)
    {
        $device = Device::where('user_id',$cu->id)->first();
        if ($device) {
            $device->user_id=0;
            $device->facility_id=0;
            $device->status='unallocated';
            $device->save();
        }
    }
 
    private function addUpdateFacilities(Request $request, $user, $u)
    {
        // TODO remove existing ones
        /*
        $uf = UserFacility::where('user_id',$u->id)->pluck('id');
        if ($uf) { UserFacility::destroy($uf); }
        
        // add Primary
        $u->facility()->create([ 'team_id' => $user->current_team_id, 
                         'facility_id'=>$request->primary_facility, 
                         'primary'=>1, 'supervised'=>1,
                         'modified_by'=>$user->id
                       ]);
            
        // add Supervised facility
        if (count($request->supervised_facility)>0) {
            foreach($request->supervised_facility as $f) {
                if ($f['id'] != $request->primary_facility) {
                     $u->facility()->create([ 
                                 'team_id' => $user->current_team_id, 
                                 'facility_id'=>$f['id'], 
                                 'primary'=>0, 'supervised'=>1,
                                 'modified_by'=>$user->id
                               ]);
                } 
            }
        }*/
    }
}
