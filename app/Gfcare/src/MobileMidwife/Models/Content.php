<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_mm_service_content';

    protected $guarded = [];

    protected $hidden = [];
}
