<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Groupcontroller extends Controller
{
    //

  public function showContent(Request $request, $teamId=null)
    {
        $groups = Content::all();
        return response()->json($users);
    }


}
