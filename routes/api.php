<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ArticleController,
    ArticleTypeController,
    AttendanceSheetController,
    BankController,
    DocumentTypeController,
    EmployeeController,
    ImageController,
    MachineController,
    MaintenanceSheetController,
    MaintenanceTypeController,
    NotificationController,
    PositionController,
    SupplierController,
    SupplierTypeController,
    UserController,
    WorkingSheetController

};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1/')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::post('users', [UserController::class, 'store']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);

        Route::get('employees', [EmployeeController::class, 'index']);
        Route::get('employees/{employee}', [EmployeeController::class, 'show']);
        Route::post('employees', [EmployeeController::class, 'store']);
        Route::post('employees/{employee}/generate-safe-credentials', [EmployeeController::class, 'generate_safe_credentials']);
        Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);

        Route::get('attendance-sheets', [AttendanceSheetController::class, 'index']);
        Route::get('attendance-sheets/{attendanceSheet}', [AttendanceSheetController::class, 'show']);
        Route::post('attendance-sheets', [AttendanceSheetController::class, 'store']);

        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show']);
        Route::post('suppliers', [SupplierController::class, 'store']);
        Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy']);

        Route::get('articles', [ArticleController::class, 'index']);
        Route::get('articles/{article}', [ArticleController::class, 'show']);
        Route::post('articles', [ArticleController::class, 'store']);
        Route::delete('articles/{article}', [ArticleController::class, 'destroy']);

        Route::get('machines', [MachineController::class, 'index']);
        Route::get('machines/{machine}', [MachineController::class, 'show']);
        Route::post('machines', [MachineController::class, 'store']);
        Route::delete('machines/{machine}', [MachineController::class, 'destroy']);

        Route::get('maintenance-sheets', [MaintenanceSheetController::class, 'index']);
        Route::get('maintenance-sheets/{maintenanceSheet}', [MaintenanceSheetController::class, 'show']);
        Route::post('maintenance-sheets', [MaintenanceSheetController::class, 'store']);
        Route::delete('maintenance-sheets/{maintenanceSheet}', [MaintenanceSheetController::class, 'destroy']);

        Route::get('working-sheets', [WorkingSheetController::class, 'index']);
        Route::get('working-sheets/{workingSheet}', [WorkingSheetController::class, 'show']);
        Route::post('working-sheets', [WorkingSheetController::class, 'store']);
        Route::delete('working-sheets/{workingSheet}', [WorkingSheetController::class, 'destroy']);

        Route::get('images', [ImageController::class, 'index']);
        Route::get('images/{image}', [ImageController::class, 'show']);

        Route::get('article-types', [ArticleTypeController::class, 'index']);
        Route::get('article-types/{articleType}', [ArticleTypeController::class, 'show']);
        Route::post('article-types', [ArticleTypeController::class, 'store']);
        Route::put('article-types/{articleType}', [ArticleTypeController::class, 'update']);
        Route::delete('article-types/{articleType}', [ArticleTypeController::class, 'destroy']);

        Route::get('maintenance-types', [MaintenanceTypeController::class, 'index']);

        Route::get('positions', [PositionController::class, 'index']);

        Route::get('document-types', [DocumentTypeController::class, 'index']);

        Route::get('banks', [BankController::class, 'index']);

        Route::get('supplier-types', [SupplierTypeController::class, 'index']);

    });
});


