<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/dashboard', function (Request $request) {
    return $request->user();
});

Route::get('database-backup','API\APIController@databaseBackup');

Route::post('check-in-out-status','API\APIController@checkInOutStatus');
Route::post('check-in-out','API\APIController@checkInOut');

Route::get('get-events','API\APIController@events');
Route::get('event-info','API\APIController@eventInfo');
