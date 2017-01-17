<?php

namespace App\Gfcare\src\CCH\Models;

use App\Spark;
use App\User;
use App\Teams\Facility;
use App\Scopes\TeamScopeTrait;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_cch_devices';

    protected $guarded = [];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(Spark::model('users', User::class));
    }

    public function facility()
    {
        return $this->hasOne('Facility', 'id', 'facility_id');
    }

    public function getUserName()
    {
        return ($this->user == null) ? 'Unassigned' : $this->user->name;
    }
}
