<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AppUser;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $appuser = new AppUser();
        $appdata =  $request->app_data;

       
 
        if($appdata=="tz")
        {
         $appuser->firstname = $request->firstname;
         $appuser->lastname = $request->lastname;
         $appuser->DOB = $request->dob;
         $appuser->gender = $request->gender;
         $appuser->app_data = "tz";
         $appuser->user_gen_id = "NA";
         $appuser->client_type = $request->client_type;
         $appuser->insured = $request->insured;
         $appuser->national_id = $request->national_id;
         $appuser->afya_phonenumber =  $request->afya_phonenumber;

         $appuser -> save();
         return response()->json('Ok');
       }
       else if($appdata=="kj")
       {
         $appuser->firstname = $request->firstname;
         $appuser->lastname = $request->lastname;
         $appuser->DOB = $request->dob;
         $appuser->gender = $request->gender;
         $appuser->app_data = "tz";
         $appuser->user_gen_id = "NA";
         $appuser->client_type = $request->client_type;
         $appuser->insured = $request->insured;
         $appuser->national_id = $request->national_id;
         $appuser->afya_phonenumber =  $request->afya_phonenumber;
         $appuser->language =  $request->language;
         $appuser->location =  $request->location;
         $appuser -> save();
         return response()->json('Ok');
       }
       else if($appdata=="ml")
       	{
          

       	}
       	else
       		 return response()->json(['error'=>'request has no app_data'], 422);

       //  response()->json(['status'=>'Ok', 'responsecode'=>'00']);
         
         
    }
}
