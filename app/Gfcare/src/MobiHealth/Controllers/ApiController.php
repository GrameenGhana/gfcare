<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use App\Gfcare\Core\BaseController;
use App\Http\Controllers\Controller;
use App\Gfcare\src\MobiHealth\Models\Useage;

class ApiController extends Controller
{
    public function getMessagePlayCountBySubModule()
    {
        $u = Useage::getMessagePlayBySubModule();
        return response()->json($u);
    }
}
