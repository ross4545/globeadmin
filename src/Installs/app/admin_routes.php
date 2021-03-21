<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LA\BackupsController;
use App\Http\Controllers\LA\DashboardController;
use App\Http\Controllers\LA\DepartmentsController;
use App\Http\Controllers\LA\EmployeesController;
use App\Http\Controllers\LA\OrganizationsController;
use App\Http\Controllers\LA\PermissionsController;
use App\Http\Controllers\LA\RolesController;
use App\Http\Controllers\LA\UploadsController;
use App\Http\Controllers\LA\UsersController;
use Globesol\globeadmin\Helpers\LAHelper;
use Illuminate\Support\Facades\Route;

/* ================== Homepage ================== */

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
//Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', [UploadsController::class,'get_file']);

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";

    $as = config('laraadmin.adminRoute').'.';

    // Routes for Laravel 5.3
    Route::get('/logout', [LoginController::class,'logout']);


Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

    /* ================== Dashboard ================== */

    Route::get(config('laraadmin.adminRoute'), [DashboardController::class,'index']);
    Route::get(config('laraadmin.adminRoute'). '/dashboard', [DashboardController::class,'index']);

    /* ================== Users ================== */
    Route::resource(config('laraadmin.adminRoute') . '/users', UsersController::class);
    Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', [UsersController::class,'dtajax']);

    /* ================== Uploads ================== */
    Route::resource(config('laraadmin.adminRoute') . '/uploads', UploadsController::class);
    Route::post(config('laraadmin.adminRoute') . '/upload_files', [UploadsController::class,'upload_files']);
    Route::get(config('laraadmin.adminRoute') . '/uploaded_files', [UploadsController::class,'uploaded_files']);
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', [UploadsController::class,'update_caption']);
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', [UploadsController::class,'update_filename']);
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', [UploadsController::class,'update_public']);
    Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', [UploadsController::class,'delete_file']);

    /* ================== Roles ================== */
    Route::resource(config('laraadmin.adminRoute') . '/roles', RolesController::class);
    Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', [RolesController::class,'dtajax']);
    Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', [RolesController::class,'save_module_role_permissions']);

    /* ================== Permissions ================== */
    Route::resource(config('laraadmin.adminRoute') . '/permissions', PermissionsController::class);
    Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', [PermissionsController::class,'dtajax']);
    Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', [PermissionsController::class,'save_permissions']);

    /* ================== Departments ================== */
    Route::resource(config('laraadmin.adminRoute') . '/departments', DepartmentsController::class);
    Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', [DepartmentsController::class,'dtajax']);

    /* ================== Employees ================== */
    Route::resource(config('laraadmin.adminRoute') . '/employees', EmployeesController::class);
    Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', [EmployeesController::class,'dtajax']);
    Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', [EmployeesController::class,'change_password']);

    /* ================== Organizations ================== */
    Route::resource(config('laraadmin.adminRoute') . '/organizations', OrganizationsController::class);
    Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', [OrganizationsController::class,'dtajax']);

    /* ================== Backups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/backups', BackupsController::class);
    Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', [BackupsController::class,'dtajax']);
    Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', [BackupsController::class,'create_backup_ajax']);
    Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', [BackupsController::class,'downloadBackup']);
});
