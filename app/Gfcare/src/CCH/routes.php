<?php


Route::group(['middleware' => ['web','auth'], 'prefix'=>'chn-on-the-go'], function ($router) {
    
    $cpath = 'App\Gfcare\src\CCH\Controllers';    
    $router->get('/', $cpath.'\HomeController@show');
        
    $router->get('content/image/{type}/{id}',    $cpath.'\ContentController@displayImage');
    
    $router->get('content/lc/references',          $cpath.'\ContentController@getLCReferences');
    $router->put('content/lc/references/{id}',     $cpath.'\ContentController@updateLCReference');    
    $router->post('content/lc/references',         $cpath.'\ContentController@storeLCReference');
    $router->delete('content/lc/references/{id}',  $cpath.'\ContentController@destroyLCReference');

    $router->get('content/poc/sections',         $cpath.'\ContentController@getPOCSections');
    $router->put('content/poc/sections/{id}',    $cpath.'\ContentController@updatePOCSection');
    $router->post('content/poc/sections',        $cpath.'\ContentController@storePOCSection');
    $router->delete('content/poc/sections/{id}', $cpath.'\ContentController@destroyPOCSection');

    $router->get('content/poc/subsections',         $cpath.'\ContentController@getPOCSubSections');
    $router->put('content/poc/subsections/{id}',    $cpath.'\ContentController@updatePOCSubSection');
    $router->post('content/poc/subsections',        $cpath.'\ContentController@storePOCSubSection');
    $router->delete('content/poc/subsections/{id}', $cpath.'\ContentController@destroyPOCSubSection');

    $router->get('content/poc/topics',         $cpath.'\ContentController@getPOCTopics');
    $router->put('content/poc/topics/{id}',    $cpath.'\ContentController@updatePOCTopic');    
    $router->post('content/poc/topics',        $cpath.'\ContentController@storePOCTopic');
    $router->delete('content/poc/topics/{id}', $cpath.'\ContentController@destroyPOCTopic');

    $router->get('system/users', $cpath.'\UserController@show');
    $router->put('system/users/{id}', $cpath.'\UserController@update');
    $router->post('system/users',     $cpath.'\UserController@store');
    $router->delete('system/users/{id}', $cpath.'\UserController@destroy');

    $router->get('system/roles', $cpath.'\RoleController@show');
    $router->get('system/roles/{role}', $cpath.'\RoleController@getUsers');
    $router->put('system/roles/{id}', $cpath.'\RoleController@update');
    $router->post('system/roles',     $cpath.'\RoleController@store');
    $router->delete('system/roles/{id}', $cpath.'\RoleController@destroy');
        
});

Route::group(['middleware' => ['api','jwt.auth'], 'prefix'=>'api/chn-on-the-go'], function ($router) {
    $cpath = 'App\Gfcare\src\CCH\Controllers';    

    $router->get('clients', $cpath.'\ClientsController@index');
    $router->post('clients/register', $cpath.'\ClientsController@store');
    $router->post('clients/enroll', $cpath.'\ClientsController@enroll');

    $router->get('content/references', $cpath.'\ContentController@getLCReferences');
    $router->get('content/poc/sections', $cpath.'\ContentController@getPOCSections');
    $router->get('content/poc/subsections', $cpath.'\ContentController@getPOCSubSections');
    $router->get('content/poc/topics', $cpath.'\ContentController@getPOCTopics');

});
