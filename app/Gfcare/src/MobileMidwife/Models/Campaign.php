<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Scopes\TeamScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use TeamScopeTrait;

    protected $table = 'mod_mm_service_campaigns';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['programs'];

    public function programs()
    {
        return $this->hasMany('\App\Gfcare\src\MobileMidwife\Models\Program');
    }
}
