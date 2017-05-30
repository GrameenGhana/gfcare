<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'mod_mm_zmessages';

    protected $guarded = [];

    protected $hidden = [];
}
