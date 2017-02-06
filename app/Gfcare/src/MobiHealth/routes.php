<?php


Route::group(['middleware' => ['web','auth'], 'prefix'=>'mobihealth'], function ($router) {
    $cpath = 'App\Gfcare\src\MobiHealth\Controllers';    
    
    $router->get('/', $cpath.'\HomeController@show');
    
    $router->get('system/users', $cpath.'\UserController@show');
    $router->put('system/users/{id}', $cpath.'\UserController@update');
    $router->post('system/users',     $cpath.'\UserController@store');
    $router->delete('system/users/{id}', $cpath.'\UserController@destroy');

    $router->get('system/referrals', $cpath.'\ReferralController@show');
    $router->put('system/referrals/{id}', $cpath.'\ReferralController@update');
    $router->post('system/referrals',     $cpath.'\ReferralController@store');
    $router->delete('system/referrals/{id}', $cpath.'\ReferralController@destroy');

    
    $router->get('system/roles', $cpath.'\RoleController@show');
    $router->get('system/roles/{role}', $cpath.'\RoleController@getUsers');
    //$router->put('system/roles/{id}', $cpath.'\RoleController@update');
    //$router->post('system/roles',     $cpath.'\RoleController@store');
    //$router->delete('system/roles/{id}', $cpath.'\RoleController@destroy');
    
    // APIs
    $router->get('/api/messageplaycountbysubmodule', $cpath.'\ApiController@getMessagePlayCountBySubModule');

});

Route::group(['middleware' => ['api','jwt.auth'], 'prefix'=>'api/mobihealth'], function ($router) {

});
