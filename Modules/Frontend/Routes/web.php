<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    Route::get('/', 'FrontendController@index')->name('homepage');
});

Route::post('/signin', 'FrontendController@signin')
    ->name('student.signin');

Route::prefix('student')->middleware(['web', 'studentAuth'])->group(function () {
    Route::get('dashboard', 'FrontendController@dashboard')
        ->name('student.dashboard');

    Route::get('logout', 'FrontendController@logout')
        ->name('student.logout');
});
