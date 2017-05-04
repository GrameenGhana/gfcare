<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Scopes\TeamScopeTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Referral extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_mobi_referrals';

    protected $guarded = [];

    protected $hidden = [];

 	protected function getArrayableAppends()
    {
        $appends = ['volunteer_name','supervisor_name'];
        $this->appends = array_merge($this->appends, $appends);

        return parent::getArrayableAppends();
    }

    public function getVolunteernameAttribute() 
    {
 		$u =  DB::table('users')
                ->select(DB::raw('name'))
                ->where('id',$this->mhv)
                ->first(); 
		return $u->name;
    }

    public function getSupervisornameAttribute() 
    {
 		$u =  DB::table('users')
                ->select(DB::raw('name'))
                ->where('id',$this->supervisor)
                ->first(); 
		return $u->name;
    }

    public function volunteer()
    {
        return $this->belongsTo('\App\Gfcare\src\MobiHealth\Models\MobiUser','mhv');
    }

    public function supervisor()
    {
        return $this->belongsTo('\App\Gfcare\src\MobiHealth\Models\MobiUser','supervisor');
    }
}
