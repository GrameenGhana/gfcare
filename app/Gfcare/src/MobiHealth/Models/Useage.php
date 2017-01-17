<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Spark;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScopeTrait;


class Useage extends Model
{
    use TeamScopeTrait;
    
    protected $table = 'mod_mobi_log_useage';

    protected $guarded = [];

    protected $hidden = [];


    static function getMessagePlayBySubModule()
    {
        return DB::table('mod_mobi_log_useage')
                     ->select(DB::raw('count(*) as play_count, sub_module'))
                     ->groupBy('sub_module')
                     ->get(); 
    }
}
