<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Teams\Device;

class DeviceController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $devices = Device::all();
        return response()->json($devices);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

         $this->validate($request, [
                                   'type' => 'required|max:255',
                                   'tag' => 'required|max:255',
                                   'color' => 'required|max:255',
                                   'imei' => 'required|max:255',
                                  ]); 

        $device = Device::whereRaw('type=? and tag=?',array($request->type,$request->tag))->first();

        if(!$device) {
            $device = new Device();
            $device->type = $request->type;
            $device->tag = $request->tag;
            $device->color = $request->color;
            $device->imei = $request->imei;
            $device->status = 'unallocated'; 
            $device->modified_by = $user->id;
            $device->team_id = $user->current_team_id;
            $device->user_id = 0;
            $device->facility_id = 0; 
            $device->save();
        }
        
        return $device; 
    }

    public function update(Request $request, $deviceId)
    {
        $user = $request->user();
        $device = Device::findOrFail($deviceId);
      $this->validate($request, [
                                   'type' => 'required|max:255',
                                   'tag' => 'required|max:255',
                                   'color' => 'required|max:255',
                                   'imei' => 'required|max:255',
                                   'status' => 'required|max:255',
                                  ]);  

        $device->type = $request->type;
        $device->tag = $request->tag;
        $device->color = $request->color;
        $device->imei = $request->imei;
        $device->status = $request->status; 
        $device->modified_by = $user->id;
        $device->save();

        return $device;; 
    }

    public function destroy(Request $request, $deviceId)
    {
        $device = Device::findOrFail($deviceId); 
        $device->delete();
        return $this->getDevices(); 
    }

    private function getDevices()
    {
        return Devices::all();
    }
}
