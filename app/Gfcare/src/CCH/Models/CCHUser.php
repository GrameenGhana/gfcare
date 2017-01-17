<?php

namespace App\Gfcare\src\CCH\Models;

use App\User;
use App\Scopes\UsersModuleScopeTrait;

class CCHUser extends User
{
    use UsersModuleScopeTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->with = array_merge($this->with, ['info','facility','device']);
    }
    
    public function info() 
    {
        return $this->hasOne('App\Gfcare\src\CCH\Models\UserInfo','user_id','id');
    }

    public function device() 
    {
        return $this->hasOne('App\Gfcare\src\CCH\Models\Device', 'user_id', 'id');
    }

    public function facility()
    {
        return $this->hasMany('App\Gfcare\src\CCH\Models\UserFacility','user_id');
    }
}
