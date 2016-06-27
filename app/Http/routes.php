<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Web System Auth Routes
 */
use App\Models\AdmMenuList;

Route::group(['middleware' => ['web']], function ()
{

    // Authentication Routes...
//    Route::get('login', 'Web\Auth\AuthController@showLoginForm');
//    Route::post('login', 'Web\Auth\AuthController@loginAction');
//    Route::get('logout', 'Web\Auth\AuthController@logout');
//    Route::get('verify', 'Web\Auth\AuthController@verifyAction');

    // Registration Routes...
//    Route::get('register', 'Web\Auth\AuthController@showRegistrationForm');
//    Route::post('register', 'Web\Auth\AuthController@registerAction');

    // Password Reset Routes...
//    Route::get('password/reset/{token?}', 'Web\Auth\PasswordController@showResetForm');
//    Route::post('password/email', 'Web\Auth\PasswordController@sendResetLinkEmail');
//    Route::post('password/resetUser', 'Web\Auth\PasswordController@resetLoginUser');

    //home
    Route::get('/', 'Web\IndexController@index');
});

/**
 * Admin System Auth Routes
 */
Route::group(['middleware' => ['web']], function ()
{

    // Authentication Routes...
    Route::get('adm/login', 'Admin\Auth\AuthController@showLoginForm');
    Route::post('adm/login', 'Admin\Auth\AuthController@loginAction');
    Route::get('adm/logout', 'Admin\Auth\AuthController@logout');
    Route::get('adm/verify', 'Admin\Auth\AuthController@verifyAction');

    // Registration Routes...
    Route::get('adm/register', 'Admin\Auth\AuthController@showRegistrationForm');
    Route::post('adm/register', 'Admin\Auth\AuthController@registerAction');

    // Password Reset Routes...
//    Route::get('adm/password/reset/{token?}', 'Admin\Auth\PasswordController@showResetForm');
//    Route::post('adm/password/email', 'Admin\Auth\PasswordController@sendResetLinkEmail');
    Route::post('adm/password/resetUser', 'Admin\Auth\PasswordController@resetLoginUser');

    //home
    Route::get('adm/', 'Admin\IndexController@index');
    Route::get('adm/welcome', 'Admin\Home\WelcomeController@index');
    Route::resource('adm/menu', 'Admin\Menu\MenuController');
    Route::resource('adm/parent', 'Admin\Menu\ParentController');

    Route::get('adm/profile', 'Admin\User\UserController@profile');
    Route::get('adm/user', 'Admin\User\UserController@index');

    Route::get('adm/billingUsers', 'Admin\Billings\BillingUsersController@index');
    Route::get('adm/billingLost', 'Admin\Billings\BillingLostController@index');
    Route::post('adm/billingResend', 'Admin\Billings\BillingLostController@resend');

    Route::resource('adm/games', 'Admin\Games\GamesListController');
    Route::resource('adm/gameServer', 'Admin\Games\GameServerListController');
    Route::resource('adm/gamePackage', 'Admin\Games\GamePackageListController');
    Route::resource('adm/billings', 'Admin\Billings\BillingsController');
    Route::resource('adm/billingUsers', 'Admin\Billings\BillingUsersController');

    //page
    Route::get('adm/page/user', 'Admin\User\UserController@page');
    Route::get('adm/page/menu', 'Admin\Menu\MenuController@page');
    Route::get('adm/page/parent', 'Admin\Menu\ParentController@page');
    Route::get('adm/page/billings', 'Admin\Billings\BillingsController@page');
    Route::get('adm/page/billingUsers', 'Admin\Billings\BillingUsersController@page');
    Route::get('adm/page/billingLost', 'Admin\Billings\BillingLostController@page');
    Route::get('adm/page/games', 'Admin\Games\GamesListController@page');
    Route::get('adm/page/gameServer', 'Admin\Games\GameServerListController@page');

    Route::get('adm/page/gamePackage', 'Admin\Games\GamePackageListController@page');
});

/**
 * 游戏渲染
 */
Route::get('/games/{game}/{server?}', 'Web\Games\PlayController@play');

/**
 * 渠道回调
 */
Route::any('/channels/{channel}', 'Web\Channels\ChannelsController@initCallback');

/**
 * 服务
 */
Route::any('/service/{service}/{action}', 'Web\Service\ServiceController@initService');

/**
 * API 调用
 */
Route::resource('/api/placed', 'Web\Api\BillingsController');


