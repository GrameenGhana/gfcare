<?php

namespace App\Teams;

use App\User;
use App\Scopes\UsersModuleScopeTrait;

class ProjectUser extends User
{
    use UsersModuleScopeTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->with = array_merge($this->with, ['info','facility','device']);
    }
    
    public function info() 
    {
        return $this->hasOne('App\Teams\UserInfo','user_id','id');
    }

    public function device() 
    {
        return $this->hasOne('App\Teams\Device', 'user_id', 'id');
    }

    public function facility()
    {
        return $this->hasMany('App\Teams\UserFacility','user_id');
    }
}
