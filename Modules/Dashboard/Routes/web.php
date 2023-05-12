<?php

Route::prefix('dashboard')->group(function() {
    Route::get('/', 'DashboardController@index');
});


