<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Spark;
use App\User;
use App\Teams\Facility;
use App\Scopes\TeamScopeTrait;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_mobi_referrals';

    protected $guarded = [];

    protected $hidden = [];
}
