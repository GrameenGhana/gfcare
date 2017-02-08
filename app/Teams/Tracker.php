<?php

namespace App\Teams;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'tracker';
    
    public function team()
    {
        return $this->belongsTo(Spark::model('teams', Team::class), 'team_id');
    }
    
    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }
    
    public function module()
    {
        return $this->belongsTo('\App\Teams\Module', 'module_id','module_id');
    }
}
