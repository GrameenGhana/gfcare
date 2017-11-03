<?php
namespace App\Gfcare\src\MobiHealth\Models;


use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_meeting_person';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['person'];

   public function person()
   {
         return $this->hasOne('\App\AppUser','id');
   }
    
}