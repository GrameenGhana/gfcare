<?php


Route::group(['middleware' => ['web','auth'], 'prefix'=>'noyawa'], function ($router) {
    
    $cpath = 'App\Gfcare\src\Noyawa\Controllers';    
    $router->get('/', $cpath.'\HomeController@show');
        
   // $router->get('clients', $cpath.'\ClientController@show');
    $router->get('clients', $cpath.'\ClientController@showKijana');
    $router->put('clients/{id}', $cpath.'\ClientController@update');
    $router->post('clients',     $cpath.'\ClientController@store');
    $router->delete('clients/{id}', $cpath.'\ClientController@destroy');

    $router->get('system/users', $cpath.'\UserController@show');
    $router->put('system/users/{id}', $cpath.'\UserController@update');
    $router->post('system/users',     $cpath.'\UserController@store');
    $router->delete('system/users/{id}', $cpath.'\UserController@destroy');
});

Route::group(['middleware' => ['api','jwt.auth'], 'prefix'=>'api/noyawa'], function ($router) {
    $cpath = 'App\Gfcare\src\Noyawa\Controllers';  

      
});
