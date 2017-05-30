<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_mm_service_programs';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['content'];

    public function campaign()
    {
        return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\Campaign');
    }

    public function content()
    {
        return $this->hasMany('\App\Gfcare\src\MobileMidwife\Models\Content');
    }

    public function subscribers()
    {
        return $this->hasMany('\App\Gfcare\src\MobileMidwife\Models\Subscriber');
    }
    
    public function subscriptions()
    {
        return $this->hasMany('\App\Gfcare\src\MobileMidwife\Models\Subscription');
    }
    
    public function validateChannel($channel) 
    {
        if ($channel==$this->channels) { return $channel; }
        if (in_array($channel,['sms','voice']) && $this->channels=='both') { return $channel; }
        return $this->channels;
    }
       
    public function validateWeek($week) 
    {
        if ($week < $this->start_week) { return $this->start_week; }
        if ($week >= $this->end_week) { return $this->end_week - 2; }
        return $week;
    }
}
