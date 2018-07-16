<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AppUser;
use App\ModMmSubscriber;
use App\GfCare\src\MobileMidwife\Models\Subscriber;
use App\GfCare\src\MobileMidwife\Models\Subscription;
use Illuminate\Support\Facades\Log;

class AppUserController extends Controller
{
    //
        
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      
        
        
    }

    public function show()
    {
        # code...
        $appusers = AppUser::all();

        return view('tempview.appuserview',  compact('appusers'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $appuser = new AppUser();
        $mmclient = new Subscriber();
        $appdata =  $request->app_data;
        $afya = $request->afya;
        
        $name = $request->firstname ." ". $request->lastname;
       
 
        if($appdata=="tz")
        {

         Log::info('Program' .$request->program_id);
         Log::info('Program' .$request->afya);
         $appuser->firstname = $request->firstname;
         $appuser->lastname = $request->lastname;
         $appuser->DOB = $request->dob;
         $appuser->gender = $request->gender;
         $appuser->phonenumber =  $request->phonenumber;
         $appuser->app_data = "tz";
         $appuser->user_gen_id = "NA";
         $appuser->client_type = $request->client_type;
         $appuser->insured = $request->insured;
         $appuser->program = $request->program_id;
         $appuser->national_id = $request->national_id;
         $appuser->uuid = $request->uuid;
         $appuser->start_week = $request->start_week;
         $appuser->mother_smartphone = $request->mother_smartphone;
         $appuser->mother_occupation = $request->mother_occupation;
         $appuser->father_name = $request->father_name;
         $appuser->father_smartphone = $request->father_smartphone;
         $appuser->father_education = $request->father_education;
         $appuser->pregnant_women_in_household = $request->pregnant_women_in_household;
         $appuser->expected_date_of_delivery = $request->expected_date_of_delivery;
         $appuser->number_of_times_gone_for_ANC = $request->number_of_times_gone_for_ANC;
         $appuser->number_of_IFAS_taken = $request->number_of_IFAS_taken;
         $appuser->planned_place_of_delivery = $request->planned_place_of_delivery;
         $appuser->children_under_59_months = $request->children_under_59_months;
         $appuser->date_of_birth = $request->date_of_birth;
         $appuser->gender_of_child = $request->gender_of_child;
         $appuser->booklet_present = $request->booklet_present;

         $appuser->save();
          Log::info('Is Pregnant Woman----------------' .$afya);
         if($afya=="yes")
         {
             Log::info('----------------- ' .$appuser);
            if(!$this->storeMobileMidwifeClient($appuser,$request,$name))
                 Log::info('mobile midwife client created');
          
         }

         
       


        
         return response()->json('Ok');
       }
       else if($appdata=="kj")
       {
         $appuser->firstname = $request->firstname;
         $appuser->lastname = $request->lastname;
         $appuser->DOB = $request->dob;
         $appuser->gender = $request->gender;
         $appuser->phonenumber =  $request->phonenumber;
         $appuser->app_data = "kj";
         $appuser->user_gen_id = "NA";
         $appuser->client_type = $request->client_type;
        // $appuser->insured = $request->insured;
         $appuser->program = $request->program_id;
         $appuser->national_id = $request->national_id;
         $appuser->language =  $request->language;
         $appuser->location =  $request->location;
         $appuser->uuid = $request->uuid;
         $appuser->start_week = $request->start_week;
         $appuser->mother_smartphone = $request->mother_smartphone;
         $appuser->mother_occupation = $request->mother_occupation;
         $appuser->father_name = $request->father_name;
         $appuser->father_smartphone = $request->father_smartphone;
         $appuser->father_education = $request->father_education;
         $appuser->pregnant_women_in_household = $request->pregnant_women_in_household;
         $appuser->expected_date_of_delivery = $request->expected_date_of_delivery;
         $appuser->number_of_times_gone_for_ANC = $request->number_of_times_gone_for_ANC;
         $appuser->number_of_IFAS_taken = $request->number_of_IFAS_taken;
         $appuser->planned_place_of_delivery = $request->planned_place_of_delivery;
         $appuser->children_under_59_months = $request->children_under_59_months;
         $appuser->date_of_birth = $request->date_of_birth;
         $appuser->gender_of_child = $request->gender_of_child;
         $appuser->booklet_present = $request->booklet_present;
         $appuser->save();

          if($afya=="yes")
         {
         	    if(!$this->storeMobileMidwifeClient($appuser,$request,$name))
                 Log::info('mobile midwife client created');
         }
         
    
         return response()->json('Ok');
       }

       else if($appdata=="ml")
       	{
          
         $appuser->firstname = $request->firstname;
         $appuser->lastname = $request->lastname;
         $appuser->DOB = $request->dob;
         $appuser->gender = $request->gender;
         $appuser->phonenumber =  $request->phonenumber;
         $appuser->app_data = "ml";
         $appuser->user_gen_id = "NA";
         $appuser->client_type = $request->client_type;
         $appuser->program = $request->program_id;
        // $appuser->insured = $request->insured;
         $appuser->national_id = $request->national_id;
         $appuser->uuid = $request->uuid;
         $appuser->start_week = $request->start_week;
         $appuser->mother_smartphone = $request->mother_smartphone;
         $appuser->mother_occupation = $request->mother_occupation;
         $appuser->father_name = $request->father_name;
         $appuser->father_smartphone = $request->father_smartphone;
         $appuser->father_education = $request->father_education;
         $appuser->pregnant_women_in_household = $request->pregnant_women_in_household;
         $appuser->expected_date_of_delivery = $request->expected_date_of_delivery;
         $appuser->number_of_times_gone_for_ANC = $request->number_of_times_gone_for_ANC;
         $appuser->number_of_IFAS_taken = $request->number_of_IFAS_taken;
         $appuser->planned_place_of_delivery = $request->planned_place_of_delivery;
         $appuser->children_under_59_months = $request->children_under_59_months;
         $appuser->date_of_birth = $request->date_of_birth;
         $appuser->gender_of_child = $request->gender_of_child;
         $appuser->booklet_present = $request->booklet_present;
         $appuser->save();
       
        if($afya=="yes")
         {

             if(!$this->storeMobileMidwifeClient($appuser,$request,$name))
                 Log::info('mobile midwife client created');
         }
         
        
        
         return response()->json(ok);

       	}
       	else
       		 return response()->json(['error'=>'request has no app_data'], 422);

       //  response()->json(['status'=>'Ok', 'responsecode'=>'00']);
         
         
    }



    public function storeMobileMidwifeClient(AppUser $mmclient,Request $request,$name)
    {
       // $mmclient= Subscriber::whereRaw('name=? and program_id=? and channel=?',array($name,$request->program_id,$request->afya_channel))->first();

          // if(!$mmclient)
           //{
        /*
            $mmclient->start_week = $request->start_week;
            $mmclient->channel = $request->afya_channel;
            $mmclient->team_id = 3;
            $mmclient->module_id =1;
            $mmclient->program_id = $request->program_id;
            $mmclient->name = $name;
            $mmclient->phone =  $request->phonenumber;
            $mmclient->dob = $request->dob;
            $mmclient->gender = $request->gender;
             $mmclient->language = $request->language;
            $mmclient->registered_by = $request->uuid;
            $mmclient->modified_by = $request->uuid;
            $mmclient->education = (isset($request->education)) ? $request->education : '';
            $mmclient->location = (isset($request->location)) ? $request->location : '';
            $mmclient->client_type = (isset($request->client_type)) ? $request->client_type : '';
            $mmclient->save();
        



        ****/
              // Sign up for program
             Subscription::subscribe($mmclient);

             return $mmclient;
    //}
   }


}
