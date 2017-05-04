<?php

namespace App\Http\Controllers\Settings;

use Exception;
use App\Spark;
use App\Teams\Tracker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;


class TrackerController extends Controller
{
    public function index()
    {
        $i = Tracker::all();
        return response()->json($i);
    }
    
    
    
    public function store(Request $request)
    {
        $rules = [
                'team_id' => 'required|exists:teams,id',
                'module_id' => 'required|exists:modules,module_id',
                'user_id' => 'required|numeric',
                'data' => 'required',
               ];
        
        $validator = Validator::make($request->all(), $rules);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors() ], 422);
        }

        $i = new Tracker();
        $i->team_id = $request->team_id;
        $i->module_id = $request->module_id;
        $i->user_id = $request->user_id;
        $i->data = $request->data;
        $i->modified_by = $request->user_id;
        $i->save();
        
        return response()->json('Ok', 200);
    }
}
