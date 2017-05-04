<?php

namespace App\Gfcare\src\MobileMidwife\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\GfCare\src\MobileMidwife\Models\Config;


class ConfigController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $i = Config::all();
        return response()->json($i);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request,[
            'sms'=>'url|max:255',
            'voice'=>'url|max:255'
        ]);

        $i = new Config();
        $i->sms = $request->sms;
        $i->voice = $request->voice;
        $i->modified_by = $user->id;
        $i->save();

        return $i;
    }

    public function update(Request $request, $teamId)
    {
        $user = $request->user();

        $this->validate($request, [
            'sms' => 'url|max:255',
            'voice' => 'url|max:255',    
        ]);

        $i = Config::where('team_id',$teamId)->first();

        if ($i) {
            $i->sms = $request->sms;
            $i->voice = $request->voice;
            $i->modified_by = $user->id;
            $i->save();
        }

        return $i; 
    }

    
    public function destroy(Request $request, $teamId)
    {
        $user = $request->user();
        $i = Config::where('team_id',$teamId)->first();
        $i->delete();
        return 'ok';
    }
}
