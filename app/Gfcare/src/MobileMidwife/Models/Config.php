<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Spark;
use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_mm_system_config';

    protected $guarded = [];

    protected $hidden = [];
    
    public static function addConfig($teamId)
    {
        $i = Config::withAllTeams()->where('team_id',$teamId)->first();
        if ($i==null) {
            $i = new Config();
            $i->team_id = $teamId;
            $i->voice = Spark::defaultVoiceLink();
            $i->sms = Spark::defaultSMSLink();
            $i->modified_by = 1;
            $i->save();
        }
    }
    
    public static function removeConfig($teamId)
    {
        $i = Config::withAllTeams()->where('team_id',$teamId)->first();
        if ($i) {
            $i->delete();
            return true;
        }
        return false;
    }
}
