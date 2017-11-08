<?php
namespace App\Gfcare\src\MobiHealth\Models;


use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
   use TeamScopeTrait;

    protected $table = 'mod_meeting';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['attendance'];

    public function attendance()
    {
       return $this->hasMany('\App\Gfcare\src\MobiHealth\Models\Attendance');
       // return $this->hasOne('\App\Gfcare\src\MobiHealth\Models\Attendance');
    }

    public function user()
    {
        return $this->belongsTo(Spark::model('users', User::class));
    }

}

