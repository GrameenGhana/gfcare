<?php


Route::group(['middleware' => ['web','auth'], 'prefix'=>'chn-on-the-go'], function ($router) {
    
    $cpath = 'App\Gfcare\src\CCH\Controllers';    
    $router->get('/', $cpath.'\HomeController@show');
    
    $router->get('content/lc/references', $cpath.'\ContentController@getLCReferences');
    $router->post('content/references',  $cpath.'\ContentController@storeLCReference');

    
    $router->get('content/poc/pages', $cpath.'\ContentController@getPOCPages');
    $router->get('content/poc/sections', $cpath.'\ContentController@getPOCSections');
    $router->get('content/poc/uploads', $cpath.'\ContentController@getPOCUploads');


    $router->get('system/users', $cpath.'\UserController@show');
    $router->put('system/users/{id}', $cpath.'\UserController@update');
    $router->post('system/users',     $cpath.'\UserController@store');
    $router->delete('system/users/{id}', $cpath.'\UserController@destroy');

    $router->get('system/devices', $cpath.'\DeviceController@show');
    $router->put('system/devices/{id}', $cpath.'\DeviceController@update');
    $router->post('system/devices',     $cpath.'\DeviceController@store');
    $router->delete('system/devices/{id}', $cpath.'\DeviceController@destroy');

    
    $router->get('system/roles', $cpath.'\RoleController@show');
    $router->get('system/roles/{role}', $cpath.'\RoleController@getUsers');
    $router->put('system/roles/{id}', $cpath.'\RoleController@update');
    $router->post('system/roles',     $cpath.'\RoleController@store');
    $router->delete('system/roles/{id}', $cpath.'\RoleController@destroy');
        
});

Route::group(['middleware' => ['api','jwt.auth'], 'prefix'=>'api/chn-on-the-go'], function ($router) {
    $cpath = 'App\Gfcare\src\CCH\Controllers';    

    $router->get('content/references', $cpath.'\ContentController@getLCReferences');
    $router->get('content/poc/pages', $cpath.'\ContentController@getPOCPages');
    $router->get('content/poc/sections', $cpath.'\ContentController@getPOCSections');

});
