<?php

namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class POCPage extends Model 
{ 
    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_pages';

	protected $fillable = array('page_description','page_name','page_shortname', 'type_of_page','page_title','page_subtitle','page_section','page_link_value','color_code','page_url');

}
