<?php

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

Route::prefix('fee-management')->group(function() {
    Route::get('/', 'FeeManagementController@index');

    Route::resource('user-courses', 'UserCoursesController');
    Route::resource('course-fees', 'CourseFeeController');
    Route::resource('user-bills', 'UserBillController');
    Route::resource('fee-collections', 'FeeCollectionController');
    Route::resource('notifications', 'NotificationController');
});
