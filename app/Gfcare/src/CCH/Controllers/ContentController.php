<?php

namespace App\Gfcare\src\CCH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


use App\GfCare\src\CCH\Models\POCSection;
use App\GfCare\src\CCH\Models\POCSubSection;
use App\GfCare\src\CCH\Models\POCTopic;
use App\GfCare\src\CCH\Models\Reference;

class ContentController extends Controller
{
    public function getLCReferences(Request $request)
    {
        $items = Reference::all();
        return response()->json($items);
    }
    
    public function getPOCSections(Request $request)
    {
        $items = POCSection::all();
        $data = ['last_update'=>$this->getLastUpdate($request), 'content'=>$items];
        return response()->json($data);
    }
    
    public function getPOCSubSections(Request $request)
    {
        $items = POCSubSection::all();
        $data = ['last_update'=>$this->getLastUpdate($request), 'content'=>$items];
        return response()->json($data);
    }
    
    public function getPOCTopics(Request $request)
    {
        $items = POCTopic::all();
        $data = ['last_update'=>$this->getLastUpdate($request), 'content'=>$items];
        return response()->json($data);
    }

    
    public function storeLCReference(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, [ 'reference_desc' => 'required',
                                    'reference_file' => 'required',
                                    'shortname' => 'required']);
        
        if ($request->reference_file<>'') {
            $name = $request->shortname.'.pdf';
            $path = Storage::disk('public')->put('cch/references/'.$name, $request->reference_file);
                            
            $reference = new Reference();
            $reference->team_id = $user->current_team_id;
            $reference->reference_desc = $request->reference_desc;
            $reference->shortname = $request->shortname;
            $reference->reference_url =  Storage::disk('public')->url('cch/references/'.$name);
            $reference->size = $this->formatSizeUnits(Storage::disk('public')->size('cch/references/'.$name));
            $reference->modified_by = $user->id;
            $reference->save();

            return $reference;
        } else {
            return response()->json(
                ['reference_file' => ['The file did not upload correctly.']], 422
            );
        }
    }
    
    public function storePOCSection(Request $request)
    {
        $user = $request->user();
                
        $this->validate($request, [ 'name' => 'required|max:255', 'file_name'=>'required', 'icon_file'=>'required' ]);
        
        if ($request->icon_file<>'') {
            $name = uniqid().'_'.$request->file_name;
            $path = Storage::disk('public')->put('cch/icons/'.$name, $request->icon_file);
                            
            $i = new POCSection();
            $i->team_id = $user->current_team_id;
            $i->name = $request->name;
            $i->icon_url = Storage::disk('public')->url('cch/icons/'.$name);
            $i->modified_by = $user->id;
            $i->save();

            return $i;
        } else {
            return response()->json(
                ['icon_file' => ['The file did not upload correctly.']], 422
            );
        }
    }
    
    public function storePOCSubSection(Request $request)
    {
        $user = $request->user();
                
        $this->validate($request, [ 'name' => 'required|max:255', 
                                    'section_id' => 'required|exists:mod_cch_content_poc_sections,id', 
                                    'file_name'=>'required', 
                                    'icon_file'=>'required' ]);
        
        if ($request->icon_file<>'') {
            $name = uniqid().'_'.$request->file_name;
            $path = Storage::disk('public')->put('cch/icons/'.$name, $request->icon_file);
                            
            $i = new POCSubSection();
            $i->team_id = $user->current_team_id;
            $i->section_id = $request->section_id;
            $i->name = $request->name;
            $i->icon_url = Storage::disk('public')->url('cch/icons/'.$name);
            $i->modified_by = $user->id;
            $i->save();

            return $i;
        } else {
            return response()->json(
                ['icon_file' => ['The file did not upload correctly.']], 422
            );
        }
    }
    
    public function storePOCTopic(Request $request)
    {
        $user = $request->user();
                
        $this->validate($request, [ 'name' => 'required|max:255', 
                                    'sub_section_id' => 'required|exists:mod_cch_content_poc_sub_sections,id', 
                                    'description' => 'required|max:255',
                                    'shortname' => 'required',
                                    'file_name'=>'required', 
                                    'upload_file'=>'required',
                                   ]);
        
        if ($request->upload_file<>'') {
            $path = Storage::disk('public')->put('cch/topics/'.$request->file_name, $request->upload_file);
                            
            $i = new POCTopic();
            $i->team_id = $user->current_team_id;
            $i->sub_section_id = $request->sub_section_id;
            $i->name = $request->name;
            $i->shortname = $request->shortname;
            $i->description = $request->description;
            $i->file_url = Storage::disk('public')->url('cch/topics/'.$request->file_name);
            $i->modified_by = $user->id;
            $i->save();

            return $i;
        } else {
            return response()->json(
                ['upload_file' => ['The file did not upload correctly.']], 422
            );
        }
    }

    

    public function updateLCReference(Request $request, $id)
    {
        $user = $request->user();
        $i = Reference::findOrFail($id);
        $this->validate($request, [ 'reference_desc' => 'required',
                                    'shortname' => 'required']);
         
        if ($request->reference_file<>'') {
            $name = $request->shortname.'.pdf';
            $path = Storage::disk('public')->put('cch/references/'.$name, $request->reference_file);
            $i->reference_url =  Storage::disk('public')->url('cch/references/'.$name);
            $i->size = $this->formatSizeUnits(Storage::disk('public')->size('cch/references/'.$name));
        }
        
        $i->reference_desc = $request->reference_desc;
        $i->shortname = $request->shortname;
        $i->modified_by = $user->id;
        $i->save();

        return $i; 
    }
    
    public function updatePOCSection(Request $request, $id)
    {
        $user = $request->user();
        $i = POCSection::findOrFail($id);
        $this->validate($request, [ 'name' => 'required|max:255' ]);

         
        if ($request->icon_file<>'') {
            $name = uniqid().'_'.$request->file_name;
            $path = Storage::disk('public')->put('cch/icons/'.$name, $request->icon_file);
            $i->icon_url = Storage::disk('public')->url('cch/icons/'.$name);
        }
                         
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();

        return $i; 
    }
            
    public function updatePOCSubSection(Request $request, $id)
    {
        $user = $request->user();
        $i = POCSubSection::findOrFail($id);
        $this->validate($request, [ 'name' => 'required|max:255',                                     
                                    'section_id' => 'required|exists:mod_cch_content_poc_sections,id', ]);

         
        if ($request->icon_file<>'') {
            $name = uniqid().'_'.$request->file_name;
            $path = Storage::disk('public')->put('cch/icons/'.$name, $request->icon_file);
            $i->icon_url = Storage::disk('public')->url('cch/icons/'.$name);
        }
                         
        $i->name = $request->name;
        $i->section_id = $request->section_id;
        $i->modified_by = $user->id;
        $i->save();

        return $i; 
    }
    
    public function updatePOCTopic(Request $request, $id)
    {
        $user = $request->user();
        $i = POCTopic::findOrFail($id);
                        
        $this->validate($request, [ 'name' => 'required|max:255', 
                                    'sub_section_id' => 'required|exists:mod_cch_content_poc_sub_sections,id', 
                                    'description' => 'required|max:255',
                                    'shortname' => 'required'
                                   ]);

         
        if ($request->upload_file<>'') {
            $path = Storage::disk('public')->put('cch/topics/'.$request->file_name, $request->upload_file);                         
            $i->file_url = Storage::disk('public')->url('cch/topics/'.$request->file_name);
        }
                         
        $i->sub_section_id = $request->sub_section_id;
        $i->name = $request->name;
        $i->shortname = $request->shortname;
        $i->description = $request->description;
        $i->modified_by = $user->id;
        $i->save();

        return $i; 
    }
    
    
    public function destroyLCReference(Request $request, $id)
    {
        $i = Reference::findOrFail($id); 
        Storage::disk('public')->delete(preg_replace('/storage\//','',$i->reference_url));
        $i->delete();
        return response()->json(['data' => 'Ok'], 200);
    }
    
    public function destroyPOCSection(Request $request, $id)
    {
        $i = POCSection::findOrFail($id); 
        Storage::disk('public')->delete(preg_replace('/storage\//','',$i->icon_url));
        $i->delete();
        return response()->json(['data' => 'Ok'], 200);
    }
    
    public function destroyPOCSubSection(Request $request, $id)
    {
        $i = POCSubSection::findOrFail($id); 
        Storage::disk('public')->delete(preg_replace('/storage\//','',$i->icon_url));
        $i->delete();
        return response()->json(['data' => 'Ok'], 200);
    }
    
    public function destroyPOCTopic(Request $request, $id)
    {
        $i = POCTopic::findOrFail($id); 
        Storage::disk('public')->delete(preg_replace('/storage\//','',$i->file_url));
        $i->delete();
        return response()->json(['data' => 'Ok'], 200);
    }
    
            
    private function formatSizeUnits($bytes)  
    {
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
    
    public function displayImage($type, $id) 
    {
        $file_path = null;
        
        switch ($type) {
            case 'section': $file_path = POCSection::find($id)->icon_url; break; 
            case 'subsection': $file_path = POCSubSection::find($id)->icon_url; break; 
        }
        if ($file_path) {
            $file_path = preg_replace('/storage\//','',$file_path);
            $contents = Storage::disk('public')->get($file_path);
            $mime = mime_content_type($contents); 
            $contents = base64_decode(preg_replace('/data:\w+\/\w+;base64,/','',$contents));
            header("Content-Type: ".$mime);
            header("Content-Length: " . strlen($contents));
            echo $contents;
        }
        exit;
    }

    private function getLastUpdate(Request $request)
    {
        $user = $request->user();
        $teamId = $user->current_team_id;
		$sql = "SELECT GREATEST(MAX(t.updated_at), MAX(ss.updated_at), MAX(s.updated_at)) as lu
  				  FROM `mod_cch_content_poc_topics` t
  				  JOIN mod_cch_content_poc_sub_sections ss ON ss.id = t.sub_section_id
  				  JOIN mod_cch_content_poc_sections s ON s.id = ss.section_id
  			 	 WHERE s.team_id = $teamId";
		$i = DB::select($sql);
        return $i[0]->lu;
    }
}
