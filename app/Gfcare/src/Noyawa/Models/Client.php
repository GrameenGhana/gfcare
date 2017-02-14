<?php

namespace App\Gfcare\src\Noyawa\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_noyawa_clients';

    protected $guarded = [];

    protected $hidden = [];


 	protected function getArrayableAppends()
    {
        $appends = ['volunteer_name'];
        $this->appends = array_merge($this->appends, $appends);

        return parent::getArrayableAppends();
    }

    public function getVolunteernameAttribute() 
    {
      return $this->user->name; 
    }

    public function user()
    {
        return $this->belongsTo('\App\Gfcare\src\Noyawa\Models\NoyawaUser');
    }
}
