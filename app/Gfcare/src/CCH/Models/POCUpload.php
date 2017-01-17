<?php
namespace App\Gfcare\src\CCH\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class POCUpload extends Model 
{
    use TeamScopeTrait;

	protected $table = 'mod_cch_content_poc_uploads';

	protected $fillable = array('section_id','file_url');

    public function section() 
    {
        return $this->belongsTo('App\Gfcare\src\CCH\Models\POCSection');
    }
}
