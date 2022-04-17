<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Home & DashBoard
Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
})->name('admin.home');

Route::get('/dashboard', 'DashBoardController@index')->name('admin.dashboard.index');

// Settings
Route::get('/settings', 'SettingController@edit')->name('admin.settings.edit');
Route::post('/settings', 'SettingController@update')->name('admin.settings.update');

// Profile
Route::get('/profile', 'ProfileController@edit')->name('admin.profile.edit');
Route::put('/profile', 'ProfileController@update')->name('admin.profile.update');

// User Switching
Route::get('/user-switch', 'UserSwitchController@index')->name('admin.user-switch.index');
Route::get('/user-switch/start-session/{id}', 'UserSwitchController@start')->name('admin.user-switch.start');
Route::get('/user-switch/stop-session', 'UserSwitchController@stop')->name('admin.user-switch.stop');

// Error Log
Route::get('/error-log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.error-log.index');

// Activity Log
Route::get('/activity-log', 'ActivityLogController@index')->name('admin.activity-log.index');
Route::get('/activity-log/{id}', 'ActivityLogController@show')->name('admin.activity-log.show');

// Destroy Image
Route::post('/destroy-image', 'ImageController@destroy')->name('admin.image.destroy');

// Destroy File
Route::post('/destroy-file', 'FileController@destroy')->name('admin.file.destroy');

// User Management - User
Route::resource('/user', 'UserController', [
    'names' => [
        'index' => 'admin.user.index',
        'create' => 'admin.user.create',
        'store' => 'admin.user.store',
        'show' => 'admin.user.show',
        'edit' => 'admin.user.edit',
        'update' => 'admin.user.update',
        'destroy' => 'admin.user.destroy',
    ],
    'except' => [
        'show'
    ],
]);

Route::get('/user/{id}/hard-delete-confirmation', [
    'uses' => 'UserController@hardDeleteConfirmation',
    'as' => 'admin.user.hard-delete-confirmation',
]);

Route::delete('/user/{id}/hard-delete', [
    'uses' => 'UserController@hardDelete',
    'as' => 'admin.user.hard-delete',
]);

// User Management - Role
Route::resource('/role', 'RoleController', [
    'names' => [
        'index' => 'admin.role.index',
        'create' => 'admin.role.create',
        'store' => 'admin.role.store',
        'show' => 'admin.role.show',
        'edit' => 'admin.role.edit',
        'update' => 'admin.role.update',
        'destroy' => 'admin.role.destroy',
    ],
    'except' => [
        'show'
    ],
]);

Route::get('/role/{id}/hard-delete-confirmation', [
    'uses' => 'RoleController@hardDeleteConfirmation',
    'as' => 'admin.role.hard-delete-confirmation',
]);

Route::delete('/role/{id}/hard-delete', [
    'uses' => 'RoleController@hardDelete',
    'as' => 'admin.role.hard-delete',
]);

// User Management - Permission
Route::resource('/permission', 'PermissionController', [
    'names' => [
        'index' => 'admin.permission.index',
        'create' => 'admin.permission.create',
        'store' => 'admin.permission.store',
        'show' => 'admin.permission.show',
        'edit' => 'admin.permission.edit',
        'update' => 'admin.permission.update',
        'destroy' => 'admin.permission.destroy',
    ],
    'except' => [
        'show'
    ],
]);

Route::get('/permission/{id}/hard-delete-confirmation', [
    'uses' => 'PermissionController@hardDeleteConfirmation',
    'as' => 'admin.permission.hard-delete-confirmation',
]);

Route::delete('/permission/{id}/hard-delete', [
    'uses' => 'PermissionController@hardDelete',
    'as' => 'admin.permission.hard-delete',
]);

// Page
Route::panelResource('page', 'PageController', [
    'sortable' => true,
    'softDelete' => true,
]);

// Sentence
Route::panelResource('sentence', 'SentenceController', [
    'softDelete' => true,
]);

//Article
Route::panelResource('article', 'ArticleController', [
    'sortable' => true, 
    'softDelete' => true,
]);

//Lazanya
Route::panelResource('lazanya', 'LazanyaController', [
    'sortable' => true, 
    'softDelete' => true,
]);

//Category
Route::panelResource('category', 'CategoryController', [
    'sortable' => true, 
    'softDelete' => true,
]);

//INNER_PART_FOR_STUB_GENERATION_DONT_DELETE



