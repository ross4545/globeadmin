<?php

use Globesol\globeadmin\Helpers\LAHelper;
use Illuminate\Support\Facades\Route;
use Globesol\globeadmin\Controllers;
use Globesol\globeadmin\Controllers\ModuleController;
use Globesol\globeadmin\Controllers\FieldController;
$as = "";

$as = config('laraadmin.adminRoute') . '.';
Route::group([
   // 'namespace' => 'Globesol\globeadmin\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth']
], function () {
    Route::post(config('laraadmin.adminRoute') . '/check_unique_val/{field_id}', [FieldController::class,'check_unique_val']);
    Route::post(config('laraadmin.adminRoute') . '/ajax_module_dropdown', [ModuleController::class,'getDropDownData'])->name('Module.information');
    Route::post(config('laraadmin.adminRoute') . '/ajax_custom_dropdown', [ModuleController::class,'getListData'])->name('custom.information');;

});
/**
 * Connect routes with ADMIN_PANEL permission(for security) and 'Globesol\globeadmin\Controllers' namespace
 * and '/admin' url.
 */
Route::group([
 //   'namespace' => 'Globesol\globeadmin\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth'] // 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN'
], function () {
    
    /* ================== Modules ================== */
    Route::resource(config('laraadmin.adminRoute') . '/modules', ModuleController::class);
    Route::resource(config('laraadmin.adminRoute') . '/module_fields', FieldController::class);
    Route::get(config('laraadmin.adminRoute') . '/module_generate_crud/{model_id}', [ModuleController::class,'generate_crud']);
    Route::get(config('laraadmin.adminRoute') . '/module_generate_migr/{model_id}', [ModuleController::class,'generate_migr']);
    Route::get(config('laraadmin.adminRoute') . '/module_generate_update/{model_id}', [ModuleController::class,'generate_update']);
    Route::get(config('laraadmin.adminRoute') . '/module_generate_migr_crud/{model_id}', [ModuleController::class,'generate_migr_crud']);
    Route::get(config('laraadmin.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', [ModuleController::class,'set_view_col']);
    Route::post(config('laraadmin.adminRoute') . '/save_role_module_permissions/{id}', [ModuleController::class,'save_role_module_permissions']);
    Route::get(config('laraadmin.adminRoute') . '/save_module_field_sort/{model_id}', [ModuleController::class,'save_module_field_sort']);
    Route::get(config('laraadmin.adminRoute') . '/module_fields/{id}/delete', [FieldController::class,'destroy']);
    Route::post(config('laraadmin.adminRoute') . '/get_module_files/{module_id}', [ModuleController::class,'get_module_files']);
    Route::post(config('laraadmin.adminRoute') . '/module_update', [ModuleController::class,'update']);
    Route::post(config('laraadmin.adminRoute') . '/module_field_listing_show', [FieldController::class,'module_field_listing_show_ajax']);





    /* ================== Code Editor ================== */
    /*Route::get(config('laraadmin.adminRoute') . '/lacodeeditor', function () {
        if(file_exists(resource_path("views/la/editor/index.blade.php"))) {
            return redirect(config('laraadmin.adminRoute') . '/laeditor');
        } else {
            // show install code editor page
            return View('la.editor.install');
        }
    });
    */
    /* ================== Menu Editor ================== */
    Route::resource(config('laraadmin.adminRoute') . '/la_menus', 'MenuController');
    Route::post(config('laraadmin.adminRoute') . '/la_menus/update_hierarchy', [MenuController::class,'update_hierarchy']);
    
    /* ================== Configuration ================== */
    Route::resource(config('laraadmin.adminRoute') . '/la_configs', \App\Http\Controllers\LA\LAConfigController::class);
    
    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('laraadmin.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController::class,'index'
        ]);
        */
    });
});
