<?php

namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class POCSubSection extends Model 
{ 
    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_sub_sections';

    protected $with = ['topics'];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['section']);
        return parent::getArrayableAppends();
    }

    public function getSectionAttribute() 
    {
      $i =  DB::table('mod_cch_content_poc_sections')
                ->select(DB::raw('name'))
                ->where('id',$this->section_id)
                ->first();
      return ($i==null) ? $i : $i->name;
    }

    public function topics() 
    {
        return $this->hasMany('App\Gfcare\src\CCH\Models\POCTopic','sub_section_id');
    }
}
