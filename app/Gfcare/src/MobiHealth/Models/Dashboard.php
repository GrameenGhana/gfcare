<?php

namespace App\Gfcare\src\MobiHealth\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Teams\Tracker;


class Dashboard extends Tracker
{
    public static function getMessagePlayBySubModule()
    {
        $info = [];
        $seen = [];
        $usage = Dashboard::getUsageLogs();

        foreach($usage as $u) {
            if (in_array($u->sub_module, array_keys($seen))) {
                $info[$seen[$u->sub_module]]->play_count++; 
            } else {
                $x = new \stdClass();
                $x->sub_module = $u->sub_module;
                $x->play_count = 1;
                $seen[$x->sub_module] = sizeof($info);
                array_push($info, $x);
            }
        }

        return $info;
    }


    private static function getUsageLogs() 
    {
        return Dashboard::getLogsByType('usage');
    }

    private static function getLoginLogs() 
    {
        return Dashboard::getLogsByType('login');
    }

    private static function getLogsByType($type)
    {
        $logs = [];

        $data = DB::table('tracker')
                  ->select(DB::raw('data'))
                  ->get(); 

        foreach($data as $d) {
            $m = json_decode($d->data);
            if (isset($m->log_type) && $m->log_type==$type) {
                array_push($logs, $m);
            }   
        }

        return $logs; 
    }

}
