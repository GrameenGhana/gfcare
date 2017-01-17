<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\User;
use App\Scopes\UsersModuleScopeTrait;

class MobiUser extends User
{
    use UsersModuleScopeTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->with = array_merge($this->with, ['info','facility','referral']);
    }
    
    public function info() 
    {
        return $this->hasOne('App\Gfcare\src\MobiHealth\Models\UserInfo','user_id','id');
    }

    public function referral() 
    {
        if ($this->role=='Volunteer') {
            return $this->hasOne('App\Gfcare\src\MobiHealth\Models\Referral', 'mhv', 'id');
        } else {
            return $this->hasOne('App\Gfcare\src\MobiHealth\Models\Referral', 'supervisor', 'id');
        }
    }

    public function facility()
    {
        return $this->hasMany('App\Gfcare\src\MobiHealth\Models\UserFacility','user_id');
    }
}
