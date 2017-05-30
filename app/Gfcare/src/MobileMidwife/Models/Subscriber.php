<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_mm_subscribers';

    protected $guarded = [];

    protected $hidden = [];


 	protected function getArrayableAppends()
    {
        $appends = ['age'];
        $this->appends = array_merge($this->appends, $appends);

        return parent::getArrayableAppends();
    }

    public function getAgeAttribute() 
    {
  		list($year, $month, $day) = explode('-', date('Y-m-d',strtotime($this->dob)));
  		return (date('md', date('U', mktime(0,0,0, $month,$day,$year))) > date('md')
    			? ((date('Y') - $year) - 1)
    			: (date('Y') - $year));
    }

    public function user()
    {
        return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\MobileMidwifeUser');
    }
}
