<?php


Route::group(['middleware' => 'web'], function ($router) {
    $router->get('/', 'WelcomeController@show');
        
    $router->auth();

    // Profile Dashboard
    $router->get('home', 'HomeController@show');

    // Terms Routes...
    $router->get('terms', 'TermsController@show');

    // Settings Dashboard Routes...
    $router->get('settings', 'Settings\DashboardController@show');

    // Profile Routes...
    $router->put('settings/user', 'Settings\ProfileController@updateUserProfile');

    // Team Routes...
    if (Spark::usingTeams()) {
        $router->post('settings/teams', 'Settings\TeamController@store');
        $router->get('settings/teams/{id}', 'Settings\TeamController@edit');
        $router->put('settings/teams/{id}', 'Settings\TeamController@update');
        $router->delete('settings/teams/{id}', 'Settings\TeamController@destroy');
        $router->get('settings/teams/switch/{id}', 'Settings\TeamController@switchCurrentTeam');
        $router->get('settings/teams/switchmodule/{id}', 'Settings\TeamController@switchCurrentModule');

        $router->post('settings/teams/{id}/invitations', 'Settings\InvitationController@sendTeamInvitation');
        $router->post('settings/teams/invitations/{invite}/accept', 'Settings\InvitationController@acceptTeamInvitation');
        $router->delete('settings/teams/invitations/{invite}', 'Settings\InvitationController@destroyTeamInvitationForUser');
        $router->delete('settings/teams/{team}/invitations/{invite}', 'Settings\InvitationController@destroyTeamInvitationForOwner');
        
        $router->get('tracker', 'Settings\TrackerController@index');
        $router->post('tracker', 'Settings\TrackerController@store');
        
        $router->post('settings/teams/{id}/modules', 'Settings\ModuleController@store');
        $router->delete('settings/teams/{id}/modules/{mid}', 'Settings\ModuleController@destroy');
        $router->get('settings/teams/{id}/modules/{mid}/switch', 'Settings\ModuleController@toggleModuleStatus');
        
        $router->post('settings/teams/{id}/locations', 'Settings\LocationController@storeLocation');
        $router->put('settings/teams/{id}/locations/{lid}', 'Settings\LocationController@updateLocation');
        $router->delete('settings/teams/{id}/locations/{lid}', 'Settings\LocationController@destroyLocation');
        
        $router->post('settings/teams/{id}/facilities', 'Settings\LocationController@storeFacility');
        $router->put('settings/teams/{id}/facilities/{lid}', 'Settings\LocationController@updateFacility');
        $router->delete('settings/teams/{id}/facilities/{lid}', 'Settings\LocationController@destroyFacility');
        
        $router->post('settings/teams/{id}/facilitygroups', 'Settings\LocationController@storeFacilityGroup');
        $router->put('settings/teams/{id}/facilitygroups/{lid}', 'Settings\LocationController@updateFacilityGroup');
        $router->delete('settings/teams/{id}/facilitygroups/{lid}', 'Settings\LocationController@destroyFacilityGroup');

        $router->put('settings/teams/{team}/members/{user}', 'Settings\TeamController@updateTeamMember');
        $router->delete('settings/teams/{team}/members/{user}', 'Settings\TeamController@removeTeamMember');
        $router->delete('settings/teams/{team}/membership', 'Settings\TeamController@leaveTeam');
    }

    // Security Routes...
    $router->get('password/email', 'Auth\PasswordController@getEmail');
    $router->put('settings/user/password', 'Settings\SecurityController@updatePassword');
    $router->post('settings/user/two-factor', 'Settings\SecurityController@enableTwoFactorAuth');
    $router->delete('settings/user/two-factor', 'Settings\SecurityController@disableTwoFactorAuth');

    // Subscription Routes...
    if (count(Spark::plans()) > 0) {
        $router->post('settings/user/plan', 'Settings\SubscriptionController@subscribe');
        $router->put('settings/user/plan', 'Settings\SubscriptionController@changeSubscriptionPlan');
        $router->delete('settings/user/plan', 'Settings\SubscriptionController@cancelSubscription');
        $router->post('settings/user/plan/resume', 'Settings\SubscriptionController@resumeSubscription');
        $router->put('settings/user/card', 'Settings\SubscriptionController@updateCard');
        $router->put('settings/user/vat', 'Settings\SubscriptionController@updateExtraBillingInfo');
        $router->get('settings/user/plan/invoice/{id}', 'Settings\SubscriptionController@downloadInvoice');
    }

    // Two-Factor Authentication Routes...
    if (Spark::supportsTwoFactorAuth()) {
        $router->get('login/token', 'Auth\AuthController@showTokenForm');
        $router->post('login/token', 'Auth\AuthController@token');
    }

    // User API Routes...
    $router->get('api/users/me', 'API\UserController@getCurrentUser');

    // Team API Routes...
    if (Spark::usingTeams()) {
        $router->get('api/teams/invitations', 'API\InvitationController@getPendingInvitationsForUser');
        $router->get('api/teams/roles', 'API\TeamController@getTeamRoles');
        $router->get('api/teams/modules', 'API\TeamController@getTeamModules');
        
        $router->get('api/teams/locationtypes', 'API\TeamController@getTeamLocationTypes');
        $router->get('api/teams/{id}/locations/{type}', 'API\TeamController@getTeamLocationsByType');
        $router->get('api/teams/{id}/facilities', 'API\TeamController@getTeamFacilities');
        $router->get('api/teams/{id}/facilities/{lid}', 'API\TeamController@getTeamFacilitiesByLocation');


        $router->get('api/teams/{id}', 'API\TeamController@getTeam');
        $router->get('api/teams', 'API\TeamController@getAllTeamsForUser');
        $router->get('api/teams/invitation/{code}', 'API\InvitationController@getInvitation');
    }

    // Subscription API Routes...
    if (count(Spark::plans()) > 0) {
        $router->get('api/subscriptions/plans', 'API\SubscriptionController@getPlans');
        $router->get('api/subscriptions/coupon/{code}', 'API\SubscriptionController@getCoupon');
        $router->get('api/subscriptions/user/coupon', 'API\SubscriptionController@getCouponForUser');
    }

});

Route::group(['middleware' => ['api'],'prefix'=>'api'], function ($router) {
    $router->post('/users/login', 'API\LoginController@authenticate');
    $router->post('/users/context/{uid}/{tid}/{mid}', 'API\LoginController@setCurrentContext');
});
