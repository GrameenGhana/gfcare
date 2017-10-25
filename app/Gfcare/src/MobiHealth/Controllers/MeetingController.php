<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use App\GfCare\src\MobiHealth\Models\Meeting;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class MeetingController extends Controller
{
    //

  public function show(Request $request)
    {
        $meetings = Meeting::all();
        return response()->json($meetings);
    }


}
