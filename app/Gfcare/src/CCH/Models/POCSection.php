<?php
namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class POCSection extends Model { 

    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_sections';

    protected $with = ['subsections'];

    public function subsections() 
    {
        return $this->hasMany('App\Gfcare\src\CCH\Models\POCSubSection','section_id');
    }
}
