<?php
namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class POCTopic extends Model 
{
    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_topics';

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['section_id','section','sub_section']);
        return parent::getArrayableAppends();
    }

    public function getSectionIdAttribute() 
    {
      $i =  DB::table('mod_cch_content_poc_sub_sections')
                ->select(DB::raw('section_id'))
                ->where('id',$this->sub_section_id)
                ->first();
      return ($i==null) ? $i : $i->section_id;
    }

    public function getSectionAttribute() 
    {
      $i = null;
      $x =  DB::table('mod_cch_content_poc_sub_sections')
                ->select(DB::raw('section_id'))
                ->where('id',$this->sub_section_id)
                ->first();

      if (!is_null($x)) { 
          $i =  DB::table('mod_cch_content_poc_sections')
                ->select(DB::raw('name'))
                ->where('id',$x->section_id)
                ->first();
      }

      return ($i==null) ? $i : $i->name;
    }

    public function getSubSectionAttribute() 
    {
      $i =  DB::table('mod_cch_content_poc_sub_sections')
                ->select(DB::raw('name'))
                ->where('id',$this->sub_section_id)
                ->first();
      return ($i==null) ? $i : $i->name;
    }
}
