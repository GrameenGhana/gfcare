<?php

Route::group(['middleware' => ['web','auth'], 'prefix'=>'mobile-midwife'], function ($router) {
    $cpath = 'App\Gfcare\src\MobileMidwife\Controllers';    
   
    $router->get('/',              $cpath.'\HomeController@show');
        
    $router->get('messages',       $cpath.'\MessageController@show');
    $router->get('messages/sms',   $cpath.'\MessageController@storeSMS');
    $router->get('messages/voice', $cpath.'\MessageController@storeVoice');


    $router->get('content', $cpath.'\ContentController@showContent');
    $router->post('content', $cpath.'\ContentController@storeContent');

    $router->get('clients', $cpath.'\SubscriberController@show');
    $router->put('clients/{id}', $cpath.'\SubscriberController@update');
    $router->post('clients',     $cpath.'\SubscriberController@store');
    $router->delete('clients/{id}', $cpath.'\SubscriberController@destroy');
    
    
    $router->get('campaigns',        $cpath.'\ServiceController@showCampaigns');
    $router->post('campaigns',       $cpath.'\ServiceController@storeCampaign');

    $router->post('programs',       $cpath.'\ServiceController@storeProgram');
    $router->get('programs',        $cpath.'\ServiceController@showPrograms');

    $router->get('system/config',            $cpath.'\ConfigController@show');
    $router->put('system/config/{teamid}',   $cpath.'\ConfigController@update');
    $router->post('system/config/{teamid}',  $cpath.'\ConfigController@store');
    $router->delete('system/config/{teamid}',$cpath.'\ConfigController@destroy');
    
    $router->get('system/users', $cpath.'\UserController@show');
    $router->put('system/users/{id}', $cpath.'\UserController@update');
    $router->post('system/users',     $cpath.'\UserController@store');
    $router->delete('system/users/{id}', $cpath.'\UserController@destroy');
    
    /*
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
    */

});

Route::group(['middleware' => ['api','jwt.auth'], 'prefix'=>'api/mobile-midwife'], function ($router) {
    $cpath = 'App\Gfcare\src\MobileMidwife\Controllers';    

    $router->get('clients', $cpath.'\ClientsController@index');
    $router->post('clients/register', $cpath.'\ClientsController@store');
    $router->post('clients/enroll', $cpath.'\ClientsController@enroll');

    $router->get('programs',       $cpath.'\ServiceController@showPrograms');

    $router->get('content/references', $cpath.'\ContentController@getLCReferences');
    $router->get('content/poc/sections', $cpath.'\ContentController@getPOCSections');
    $router->get('content/poc/subsections', $cpath.'\ContentController@getPOCSubSections');
    $router->get('content/poc/topics', $cpath.'\ContentController@getPOCTopics');

});
