<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class ContentNoyawa extends Model 
{ 
    use TeamScopeTrait;

	protected $table = 'mod_mobi_content_noyawa';
}
