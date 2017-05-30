<?php

namespace App;

use App\Teams\CanJoinTeams;
use App\Gfcare\Core\CanJoinModules;
use Laravel\Cashier\Billable;
use Illuminate\Foundation\Auth\User as BaseUser;
use App\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatable;
use App\Contracts\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatableContract;

class User extends BaseUser implements TwoFactorAuthenticatableContract
{
    use Billable, TwoFactorAuthenticatable, CanJoinTeams, CanJoinModules;

    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'using_two_factor_auth'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'card_brand',
        'card_last_four',
        'extra_billing_info',
        'password',
        'remember_token',
        'stripe_id',
        'stripe_subscription',
        'two_factor_options',
    ];
        
    public function scopeSys($query)
    {
        return $query->whereIn('user_type',array('Super Admin','System'));
    }
    
    public function scopeClient($query)
    {
        return $query->where('user_type','User');
    }
    
    public function isSuperAdmin() 
    {
        return ($this->user_type=='Super Admin');
    }
    
    public function isModuleUser() 
    {
        return ($this->user_type=='User');
    }
    
    public function isSystemAdmin() 
    {
        return ($this->isSuperAdmin() || ($this->moduleRole()=='Admin'));
    }
    
    public function isSystemEditor() 
    {
        return ($this->isSuperAdmin() || $this->moduleRoleCanEdit());
    }
}
