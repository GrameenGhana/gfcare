<?php

namespace App\Gfcare\src\CCH\Models;

use App\Spark;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScopeTrait;


class UserInfo extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_cch_user_info';

    protected $guarded = [];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(Spark::model('users', User::class));
    }
}
