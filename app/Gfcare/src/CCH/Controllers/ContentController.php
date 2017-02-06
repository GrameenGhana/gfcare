<?php

namespace App\Gfcare\src\CCH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


use App\GfCare\src\CCH\Models\POCPage;
use App\GfCare\src\CCH\Models\POCSection;
use App\GfCare\src\CCH\Models\POCUpload;
use App\GfCare\src\CCH\Models\Reference;

class ContentController extends Controller
{
    public function getLCReferences(Request $request)
    {
        $items = Reference::all();
        return response()->json($items);
    }
    
    public function getPOCPages(Request $request)
    {
        $items = POCPage::all();
        return response()->json($items);
    }
    
    public function getPOCSections(Request $request)
    {
        $items = POCSection::all();
        return response()->json($items);
    }
    
    public function getPOCUploads(Request $request)
    {
        $items = POCUpload::all();
        return response()->json($items);
    }
    
    public function storeLCReference(Request $request)
    {
        $user = $request->user();
        
        function formatSizeUnits($bytes)  {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
        }
        
        $this->validate($request, [ 'reference_desc' => 'required',
                                    'reference_file' => 'required',
                                    'shortname' => 'required']);
        
        if (!is_null($request->reference_file)) {
            $name = $request->shortname.'.pdf';
            $path = Storage::disk('public')->put('references/'.$name, $request->reference_file);
                            
            $reference = new Reference();
            $reference->team_id = $user->current_team_id;
            $reference->reference_desc = $request->reference_desc;
            $reference->shortname = $request->shortname;
            $reference->reference_url =  Storage::disk('public')->url('references/'.$name);
            $reference->size = formatSizeUnits(Storage::disk('public')->size('/references/'.$name));
            $reference->modified_by = $user->id;
            $reference->save();

            return $reference;
        } else {
            return response()->json(
                ['reference_file' => ['The file did not upload correctly.']], 422
            );
        }
    }

    /* 
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'type' => 'required|max:255',
                                   'tag' => 'required|max:255',
                                   'color' => 'required|max:255',
                                   'imei' => 'required|max:255',
                                  ]);

        $device = Device::whereRaw('name=? and tag=?',array($request->type,$request->tag))->first();

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
        
        return $this->getRoles($user->current_team_id); 
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
     */
}
