<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\GfCare\src\MobiHealth\Models\MobiUser;
use App\GfCare\src\MobiHealth\Models\Role;
use App\GfCare\src\MobiHealth\Models\Referral;
use App\GfCare\src\MobiHealth\Models\UserInfo;
use App\GfCare\src\MobiHealth\Models\UserFacility;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $teamId=null)
    {
        //\Illuminate\Support\Facades\DB::enableQueryLog();
        //print_r(\Illuminate\Support\Facades\DB::getQueryLog());
        $cchu = MobiUser::all();
        return response()->json($cchu);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, ['email' => 'required|email',
                                   'name' => 'required|max:255',
                                   'password'=> 'required|min:6',
                                   'gender' => 'required',
                                   'role' => 'required',
                                   'title' => 'required',
                                   'phone_number' => 'digits_between:7,16',
                                   'primary_facility' => 'required',
                                   'status'=> 'required',
                                  ]
                                );

        $cu = MobiUser::where('email',$request->email)->first();

        if(!$cu) {
            // Add user
            $u = new MobiUser();
            $u->name = $request->name;
            $u->email = $request->email;
            $u->password = Hash::make($request->password);
            $u->current_team_id = $user->current_team_id;
            $u->current_module_id = $user->current_module_id;
            $u->phone_country_code = \App\Spark::defaultPhoneCode();
            $u->phone_number = $request->phone_number;
            $u->user_type = 'User';
            $u->save();
                        
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
                    
            // Add to module
            $r = Role::where('name',$request->role)->first();
            $u->joinModuleById($u->current_team_id, 
                               $u->current_module_id, 
                               $r->name,
                               $r->is_editor);
            
            $this->addUpdateFacilities($request, $user, $u);
           
            return MobiUser::find($u->id);
            
        } else {
            if ($cu->isModuleUser()) {
              // TODO: User already exists just add info and other things?
              // 1) Does user have info for the current module? Otherwise
            } else {
                return response()->json(['email' => ['Can add system user. Please do that from the Project settings.']], 422);
            }
        }
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u= MobiUser::findOrFail($userId);
        
        $this->validate($request, ['email' => 'required|email',
                           'name' => 'required|max:255',
                           'current_password' => 'required_with:password|min:6',
                           'password' => 'min:6',
                           'gender' => 'required',
                           'role' => 'required',
                           'title' => 'required',
                           'phone_number' => 'digits_between:7,16',
                           'primary_facility' => 'required',
                           'status'=> 'required',
                          ]
                        );
        
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
        
        // user info
        $ui = $u->info;
        $ui->gender = $request->gender;
        $ui->title = $request->title;
        $ui->ischn = $request->ischn;
        $ui->status = $request->status;
        $ui->modified_by = $user->id;
        $ui->save();
        
        // user role
        $r = Role::where('name',$request->role)->first();
        $u->modules()->updateExistingPivot($user->current_module_id, ['role' => $r->name, 'editor'=>$r->is_editor]);
        
        $this->addUpdateFacilities($request, $user, $u);
        
        return $u; 
    }

    
    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $cu = MobiUser::findOrFail($userId); 
        
        $cu->modules()->newPivotStatementForId($user->current_module_id)->where('module_id', $user->current_module_id)->delete();

        $ui = UserInfo::where('user_id',$cu->id)->first();
        if ($ui) { $ui->delete(); };
        
        $uf = UserFacility::where('user_id',$cu->id)->pluck('id');
        if ($uf) { UserFacility::destroy($uf); }
        
        if (!$cu->hasModules()) { $cu->delete(); }
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
