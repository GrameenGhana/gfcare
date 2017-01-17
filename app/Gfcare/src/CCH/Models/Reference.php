<?php
namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model 
{
    use TeamScopeTrait; 

	protected $table = 'mod_cch_content_references';
	protected $fillable = array('reference_desc','shortname','reference_url','size');

}
