<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


use App\GfCare\src\MobiHealth\Models\ContentPregnancy;
use App\GfCare\src\MobiHealth\Models\ContentNoyawa;
use App\GfCare\src\MobiHealth\Models\ContentFirstYear;
use App\GfCare\src\MobiHealth\Models\ContentVisualAid;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getVisualAids(Request $request)
    {
        $items = ContentVisualAid::all();
        return response()->json($items);
    }
    
    public function getPregnancyContent(Request $request)
    {
        $items = contentPregnancy::all();
        return response()->json($items);
    }
    
    public function getNoyawaContent(Request $request)
    {
        $items = ContentNoyawa::all();
        return response()->json($items);
    }
    
    public function getFirstYearContent(Request $request)
    {
        $items = ContentFirstYear::all();
        return response()->json($items);
    }
    
    public function storeVisualAid(Request $request)
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

    public function updatePregnancyMessage(Request $request, $msgId)
    {
        $user = $request->user();
        $content = ContentPregnancy::findOrFail($msgId);
        $this->validate($request, [ 'name' => 'required',
                                    'file_url' => 'required',
                                    'filename' => 'required']);

        $content->name = $request->name;
        $device->tag = $request->tag;
        $device->color = $request->color;
        $device->imei = $request->imei;
        $device->status = $request->status; 
        $device->modified_by = $user->id;
        $device->save();

        return $device;; 
    }

    protected function storeContent(Request $request, $content)
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
        
        if (!is_null($request->file_url)) {
            $name = $request->filename.'.mp3';
            $path = Storage::disk('public')->put('content/'.$name, $request->reference_file);
                            
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
