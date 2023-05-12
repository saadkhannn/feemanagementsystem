<?php

Route::prefix('setups')->group(function() {
    Route::resource('/', 'SetupsController');

    Route::resource('system-information', 'SystemInformationController')->middleware('can:system-information-index');
    Route::post('update-user-column-visibilities', 'SystemInformationController@updateUserColumnVisibilities');
    
    Route::resource('modules', 'ModulesController');
    Route::resource('menu', 'MenuController');

    Route::resource('submenu', 'SubmenuController');
    Route::get('submenu/{module_id}/get-menu', 'SubmenuController@getMenu');

    Route::resource('options', 'OptionsController');
    Route::get('options/{module_id}/get-menu', 'OptionsController@getMenu');
    Route::get('options/{menu_id}/get-submenu', 'OptionsController@getSubmenu');

    Route::resource('freelinks', 'FreelinksController');

    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('role-permissions', 'RolePermissionsController');

    Route::resource('users', 'UsersController');

    Route::resource('my-image', 'MyImageController');
    Route::resource('change-password', 'ChangePasswordController');

    Route::resource('departments', 'DepartmentController');
    Route::resource('courses', 'CourseController');
});
