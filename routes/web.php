<?php

use Illuminate\Support\Facades\Session;
use App\Http\Helpers\AppHelper;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::group(['middleware' => 'role:admin'], function() {
//    Route::get('/admin', function() {
//        return 'Welcome Admin';
//    });
//});


/**
 * Admin panel routes goes below
 */
Route::group(
    ['namespace' => 'Backend', 'middleware' => ['guest']], function () {
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@authenticate');
    Route::get('/forgot', 'UserController@forgot')->name('forgot');
    Route::post('/forgot', 'UserController@forgot')
        ->name('forgot');
    Route::get('/reset/{token}', 'UserController@reset')
        ->name('reset');
    Route::post('/reset/{token}', 'UserController@reset')
        ->name('reset');
}
);

Route::group(
    ['namespace' => 'Backend', 'middleware' => ['auth', 'permission']], function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/lock', 'UserController@lock')->name('lockscreen');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');

    //user management
    Route::resource('user', 'UserController');

    Route::get('/profile', 'UserController@profile')
        ->name('profile');
    Route::post('/profile', 'UserController@profile')
        ->name('profile');
    Route::get('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('user/status/{id}', 'UserController@changeStatus')
        ->name('user.status');
    Route::any('user/{id}/permission', 'UserController@updatePermission')
        ->name('user.permission');

    //user notification
    Route::get('/notification/unread', 'NotificationController@getUnReadNotification')
        ->name('user.notification_unread');
    Route::get('/notification/read', 'NotificationController@getReadNotification')
        ->name('user.notification_read');
    Route::get('/notification/all', 'NotificationController@getAllNotification')
        ->name('user.notification_all');

    //system user management
    Route::get('/administrator/user', 'AdministratorController@userIndex')
        ->name('administrator.user_index');
    Route::get('/administrator/user/create', 'AdministratorController@userCreate')
        ->name('administrator.user_create');
    Route::post('/administrator/user/store', 'AdministratorController@userStore')
        ->name('administrator.user_store');
    Route::get('/administrator/user/{id}/edit', 'AdministratorController@userEdit')
        ->name('administrator.user_edit');
    Route::post('/administrator/user/{id}/update', 'AdministratorController@userUpdate')
        ->name('administrator.user_update');
    Route::post('/administrator/user/{id}/delete', 'AdministratorController@userDestroy')
        ->name('administrator.user_destroy');
    Route::post('administrator/user/status/{id}', 'AdministratorController@userChangeStatus')
        ->name('administrator.user_status');

    Route::any('/administrator/user/reset-password', 'AdministratorController@userResetPassword')
        ->name('administrator.user_password_reset');

    //user role manage
    Route::get('/role', 'UserController@roles')
        ->name('user.role_index');
    Route::post('/role', 'UserController@roles')
        ->name('user.role_destroy');
    Route::get('/role/create', 'UserController@roleCreate')
        ->name('user.role_create');
    Route::post('/role/store', 'UserController@roleCreate')
        ->name('user.role_store');
    Route::any('/role/update/{id}', 'UserController@roleUpdate')
        ->name('user.role_update');

    // application settings routes
    Route::get('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');
    Route::post('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');

       //client routes
    Route::Resource('clients','ClientsController');
        //Route::get('/clients/add','ClientsController@create')->name('clients.create');

    

}
);



//dev routes
Route::get(
    '/make-link/{code}', function ($code) {
    if($code !== '007') {
        return 'Wrong code!';
    }

    //check if developer mode enabled?
    if(!env('DEVELOPER_MODE_ENABLED', false)) {
        return "Please enable developer mode in '.env' file.".PHP_EOL."set 'DEVELOPER_MODE_ENABLED=true'";
    }
    //remove first
    if(is_link(public_path('storage'))){
        unlink(public_path('storage'));
    }


    //create symbolic link for public image storage
    App::make('files')->link(storage_path('app/public'), public_path('storage'));
    return 'Done link';
}
);
Route::get(
    '/cache-clear/{code}', function ($code) {
    if($code !== '007') {
        return 'Wrong code!';
    }

    //check if developer mode enabled?
    if(!env('DEVELOPER_MODE_ENABLED', false)) {
        return "Please enable developer mode in '.env' file.".PHP_EOL."set 'DEVELOPER_MODE_ENABLED=true'";
    }

    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return 'clear cache';
}
);

// create tiggers
Route::get(
    '/create-triggers/{code}', function ($code) {
    if($code !== '007') {
        return 'Wrong code!';
    }

    //check if developer mode enabled?
    if(!env('DEVELOPER_MODE_ENABLED', false)) {
        return "Please enable developer mode in '.env' file.".PHP_EOL."set 'DEVELOPER_MODE_ENABLED=true'";
    }

    AppHelper::createTriggers();

    return 'Triggers created :)';
}
);

