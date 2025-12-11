<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivtyPlanController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentFileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveDaysController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\OutletTypeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuleScheduleController;
use App\Http\Controllers\SatuSehatController;
use App\Http\Controllers\ScheduleGenerateController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCoreController;
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

        // SUBMENU
        Route::get('/sub-menus', [SubmenuController::class, 'index']);
        Route::post('/sub-menus', [SubmenuController::class, 'store']);
        Route::put('/sub-menus/{id}', [SubmenuController::class, 'update']);
        Route::delete('/sub-menus/{id}', [SubmenuController::class, 'destroy']);

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
        Route::prefix('departments')->group(function () {
            Route::get('/', [DepartmentController::class, 'index']);
            Route::post('/', [DepartmentController::class, 'store']);
            Route::put('/{id}', [DepartmentController::class, 'update']);
            Route::delete('/{id}', [DepartmentController::class, 'destroy']);
            Route::post('/assign/{id_user}', [DepartmentController::class, 'assignUser']);
        });

        // BRANCH
        Route::prefix('branches')->group(function () {
            Route::get('/', [BranchController::class, 'index']);
            Route::post('/', [BranchController::class, 'store']);
            Route::post('/update/{id}', [BranchController::class, 'update']);
            Route::post('/delete/{id}', [BranchController::class, 'destroy']);
            Route::post('/assign/{id_user}', [BranchController::class, 'assignUser']);
        });

        // ATTENDANCE
        Route::prefix('attendances')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::post('/', [AttendanceController::class, 'store']);
            Route::post('/update/{id}', [AttendanceController::class, 'update']);
            Route::post('/delete/{id}', [AttendanceController::class, 'destroy']);
        });

        // EMPLOYEE
        Route::prefix('employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::post('/', [EmployeeController::class, 'store']);
            Route::post('/update/{id}', [EmployeeController::class, 'update']);
            Route::post('/delete/{id}', [EmployeeController::class, 'destroy']);
        });

        // RULE SCHEDULE
        Route::prefix('rule-schedules')->group(function () {
            Route::get('/', [RuleScheduleController::class, 'index']);
            Route::post('/', [RuleScheduleController::class, 'store']);
            Route::post('/update/{id}', [RuleScheduleController::class, 'update']);
            Route::post('/delete/{id}', [RuleScheduleController::class, 'destroy']);
        });

        // SCHEDULE GENERATE
        Route::prefix('schedule-generates')->group(function () {
            Route::get('/', [ScheduleGenerateController::class, 'index']);
            Route::post('/', [ScheduleGenerateController::class, 'store']);
            Route::post('/update/{id}', [ScheduleGenerateController::class, 'update']);
            Route::post('/delete/{id}', [ScheduleGenerateController::class, 'destroy']);
        });

        // TITLE
        Route::prefix('titles')->group(function () {
            Route::get('/', [TitleController::class, 'index']);
            Route::post('/', [TitleController::class, 'store']);
            Route::post('/update/{id}', [TitleController::class, 'update']);
            Route::post('/delete/{id}', [TitleController::class, 'destroy']);
        });

        // REPORT
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::post('/', [ReportController::class, 'store']);
            Route::post('/update/{id}', [ReportController::class, 'update']);
            Route::post('/delete/{id}', [ReportController::class, 'destroy']);
            Route::post('/check-types', [ReportController::class, 'checkTypes']);
            Route::post('/status', [ReportController::class, 'status']);
        });

        // LEAVE
        Route::prefix('leaves')->group(function () {
            Route::get('/', [LeaveController::class, 'index']);
            Route::post('/', [LeaveController::class, 'store']);
            Route::post('/update/{id}', [LeaveController::class, 'update']);
            Route::post('/delete/{id}', [LeaveController::class, 'destroy']);
            Route::post('/update-status/{id}', [LeaveController::class, 'updateStatus']);
        });

        // LEAVE DAYS
        Route::prefix('leave-days')->group(function () {
            Route::get('/', [LeaveDaysController::class, 'index']);
            Route::post('/', [LeaveDaysController::class, 'store']);
            Route::post('/update/{id}', [LeaveDaysController::class, 'update']);
            Route::post('/delete/{id}', [LeaveDaysController::class, 'destroy']);
        });

        // ACTIVITY
        Route::prefix('activities')->group(function () {
            Route::get('/', [ActivityController::class, 'index']);
            Route::post('/', [ActivityController::class, 'store']);
            Route::post('/update/{id}', [ActivityController::class, 'update']);
            Route::post('/delete/{id}', [ActivityController::class, 'destroy']);
        });

        // TASKS
        Route::prefix('tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index']);
            Route::post('/{id}', [TaskController::class, 'update']);
        });

        // TEAM AREA MEMBER
        Route::prefix('areas')->group(function () {
            Route::get('/', [AreaController::class, 'index']);
            Route::post('/members', [AreaController::class, 'member']);
        });

        // TEAM MEMBERS
        Route::prefix('team-members')->group(function () {
            Route::get('/', [TeamMemberController::class, 'index']);
        });

        // ACTIVITY PLANS
        Route::prefix('activity-plans')->group(function () {
            Route::get('/', [ActivtyPlanController::class, 'index']);
            Route::post('/', [ActivtyPlanController::class, 'store']);
            Route::get('/target-location/{id_activity}', [ActivtyPlanController::class, 'showTarget']);
            Route::get('/detail/{id_activity}', [ActivtyPlanController::class, 'showDetail']);
            Route::get('/estimate-time/{id_activity}', [ActivtyPlanController::class, 'showEstimate']);
            Route::post('/detail/{id_activity}', [ActivtyPlanController::class, 'detail']);
            Route::post('/estimate-time/{id_activity}', [ActivtyPlanController::class, 'estimate']);
            Route::post('/task/{id_user}', [ActivtyPlanController::class, 'task']);
            Route::post('/target-location/{id_activity}', [ActivtyPlanController::class, 'target']);
        });

        // DATA ACTIVITY
        Route::prefix('data-activities')->group(function () {
            Route::get('/', [ActivtyPlanController::class, 'index']);
        });

        // DAILY ACTIVITY
        Route::prefix('daily-activities')->group(function () {
            Route::get('/', [ActivtyPlanController::class, 'index']);
        });

        // OUTLET
        Route::prefix('outlets')->group(function () {
            Route::get('/', [OutletController::class, 'index']);
            Route::post('/', [OutletController::class, 'store']);
        });

        // OUTLET TYPE
        Route::prefix('outlet-types')->group(function () {
            Route::get('/', [OutletTypeController::class, 'index']);
            Route::post('/', [OutletTypeController::class, 'store']);
            Route::put('/{id}', [OutletTypeController::class, 'update']);
            Route::delete('/{id}', [OutletTypeController::class, 'destroy']);
        });

        // DOCUMENT FILE
        Route::prefix('document-files')->group(function () {
            Route::get('/', [DocumentFileController::class, 'index']);
            Route::post('/', [DocumentFileController::class, 'store']);
        });

        // USER CORE
        Route::prefix('user-cores')->group(function () {
            Route::get('/', [UserCoreController::class, 'index']);
        });


        // SATU SEHAT
        Route::prefix('satu-sehat')->group(function () {
            Route::get('/generate-token', [SatuSehatController::class, 'generateToken']);
            Route::get('/provinces', [SatuSehatController::class, 'provinces']);
            Route::get('/cities', [SatuSehatController::class, 'cities']);
            Route::get('/districts', [SatuSehatController::class, 'districts']);
            Route::get('/villages', [SatuSehatController::class, 'villages']);
            Route::get('/hospital', [SatuSehatController::class, 'hospital']);
            Route::get('/hospital/province', [SatuSehatController::class, 'hospitalsByProvince']);
            Route::get('/hospital/city', [SatuSehatController::class, 'hospitalsByCity']);
            Route::get('/hospital/district', [SatuSehatController::class, 'hospitalsByDistrict']);
        });
    });
});
