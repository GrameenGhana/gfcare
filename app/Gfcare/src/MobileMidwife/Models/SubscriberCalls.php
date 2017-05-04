<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

use App\GfCare\src\MobileMidwife\Models\Subscription;

class Call extends Model
{
    protected $table = 'mod_mm_subscriptions_calls';

    protected $guarded = [];

    protected $hidden = [];

    public function subscription()
    {
        return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\Subscription');
    }

    public function program()
    {
        return $this->belongsTo('\App\Gfcare\src\MobileMidwife\Models\Program');
    }
    
}
