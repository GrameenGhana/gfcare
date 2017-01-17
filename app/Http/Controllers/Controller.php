<?php

namespace App\Http\Controllers;

use App\InteractsWithSparkHooks;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests, InteractsWithSparkHooks;
    
    public $teamWith = ['users', 'invitations', 'modules', 'locations', 'facilities' , 'facilitygroups'];
}
