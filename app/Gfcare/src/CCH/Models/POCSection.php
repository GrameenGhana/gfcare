<?php
namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class POCSection extends Model { 

    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_sections';

	protected $fillable = array('name_of_section','sub_section', 'shortname','section_url','section_desc');

    protected $with = ['upload'];

    public function upload() 
    {
        return $this->hasOne('App\Gfcare\src\CCH\Models\POCUpload','section_id');
    }
}
