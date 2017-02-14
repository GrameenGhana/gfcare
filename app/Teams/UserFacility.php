<?php

namespace App\Teams;

use App\Spark;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScopeTrait;


class UserFacility extends Model
{
    use TeamScopeTrait;

    protected $table = 'user_facility';

    protected $guarded = [];

    protected $hidden = [];
    
    protected $with = ['facility'];

    public function user()
    {
        return $this->belongsTo(Spark::model('users', User::class));
    }
    
    public function facility()
    {
        return $this->belongsTo('App\Teams\Facility');
    }
}
