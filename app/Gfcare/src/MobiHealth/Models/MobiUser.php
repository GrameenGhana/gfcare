<?php
namespace App\Gfcare\src\MobiHealth\Models;

use App\Teams\ProjectUser;
use App\Scopes\UsersModuleScopeTrait;

class MobiUser extends ProjectUser
{
    use UsersModuleScopeTrait;

    public function __construct()
    {
        parent::__construct();
        $this->with = array_merge($this->with, ['referral']);
    }
    
    public function referral() 
    {
        if ($this->role=='Volunteer') {
            return $this->hasOne('App\Gfcare\src\MobiHealth\Models\Referral', 'mhv', 'id');
        } else {
            return $this->hasOne('App\Gfcare\src\MobiHealth\Models\Referral', 'supervisor', 'id');
        }
    }
}
