<?php

namespace App\Gfcare\src\MobileMidwife\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\GfCare\src\MobileMidwife\Models\Content;



class ContentController extends Controller
{
    //
    public function showContent(Request $request, $teamId=null)
    {
        $users = Content::all();
        return response()->json($users);
    }


    public function storeContent(Request $request)
    {

          $user = $request->user();

          $content = new Content();



          $content->team_id = $user->current_team_id;
          $content->program_id = $request->program_id;
          $content->content_type =$request->content_type;
          $content->week = $request->week;
          $content->name = $request->name;
          $content->sms_message = $request->message;
          $content->modified_by =$user->id;


          $content->save();

          return response()->json($content);

    }
}
