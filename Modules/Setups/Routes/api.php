<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/setups', function (Request $request) {
    return $request->user();
});

Route::get('designations','API\APIController@designations');
Route::get('functions','API\APIController@functions');
Route::get('sub-functions/{function_id}','API\APIController@subFunctions');
Route::get('teams/{function_id}/{sub_functtion_id}','API\APIController@teams');
Route::get('brands','API\APIController@brands');
Route::get('legal-entities/{brand_id}','API\APIController@legalEntities');

Route::apiResource('salary-head-details','API\SalaryHeadDetailsController');
Route::apiResource('att-based-salary-head-details','API\AttendanceBasedSalaryHeadDetailsController');
