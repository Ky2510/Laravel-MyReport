<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    // KHUSUS USER
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // KHUSUS SUPERADMIN
    Route::middleware('check_role:super_admin')->group(function () {
        Route::get('/superadmin/dashboard', [HomeController::class, 'dashboardSuperAdmin']);

        // ROLE
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);
        Route::put('/roles/{id}', [RoleController::class, 'update']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

        // PERMISSION
        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::post('/permissions', [PermissionController::class, 'store']);
        Route::put('/permissions/{id}', [PermissionController::class, 'update']);
        Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);

        // USER
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::post('/users/update/{id}', [UserController::class, 'update']);
        Route::post('/users/delete/{id}', [UserController::class, 'destroy']);
    });

    // KHUSUS ?
    Route::middleware('check_role:super_admin')->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'dashboardAdmin']);

        // DEPARTMENT
        Route::get('/departments', [DepartmentController::class, 'index']);
        Route::post('/departments', [DepartmentController::class, 'store']);
        Route::post('/departments/update/{id}', [DepartmentController::class, 'update']);
        Route::post('/departments/delete/{id}', [DepartmentController::class, 'destroy']);
        Route::post('/assign-department/{id_user}', [DepartmentController::class, 'assignUser']);

        // BRANCH
        Route::get('/branches', [BranchController::class, 'index']);
        Route::post('/branches', [BranchController::class, 'store']);
        Route::post('/branches/update/{id}', [BranchController::class, 'update']);
        Route::post('/branches/delete/{id}', [BranchController::class, 'destroy']);
        Route::post('/assign-branches/{id_user}', [BranchController::class, 'assignUser']);

        // ATTENDANCE
        Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::post('/attendances', [AttendanceController::class, 'store']);
        Route::post('/attendances/update/{id}', [AttendanceController::class, 'update']);
        Route::post('/attendances/delete/{id}', [AttendanceController::class, 'destroy']);

        // EMPLOYEE
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::post('/employees', [EmployeeController::class, 'store']);
        Route::post('/employees/update/{id}', [EmployeeController::class, 'update']);
        Route::post('/employees/delete/{id}', [EmployeeController::class, 'destroy']);
    });
});
