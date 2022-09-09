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

        Route::get('articles', [ArticleController::class, 'index']);
        Route::get('articles/{article}', [ArticleController::class, 'show']);

        Route::get('article-types', [ArticleTypeController::class, 'index']);
        Route::get('article-types/{articleType}', [ArticleTypeController::class, 'show']);

        Route::get('attendance-sheets', [AttendanceSheetController::class, 'index']);
        Route::get('attendance-sheets/{attendanceSheet}', [AttendanceSheetController::class, 'show']);

        Route::get('banks', [BankController::class, 'index']);
        Route::get('banks/{bank}', [BankController::class, 'show']);

        Route::get('document-types', [DocumentTypeController::class, 'index']);
        Route::get('document-types/{documentType}', [DocumentTypeController::class, 'show']);

        Route::get('employees', [EmployeeController::class, 'index']);
        Route::get('employees/{employee}', [EmployeeController::class, 'show']);

        Route::get('images', [ImageController::class, 'index']);
        Route::get('images/{image}', [ImageController::class, 'show']);

        Route::get('machines', [MachineController::class, 'index']);
        Route::get('machines/{machine}', [MachineController::class, 'show']);

        Route::get('maintenance-sheets', [MaintenanceSheetController::class, 'index']);
        Route::get('maintenance-sheets/{maintenanceSheet}', [MaintenanceSheetController::class, 'show']);

        Route::get('maintenance-types', [MaintenanceTypeController::class, 'index']);
        Route::get('maintenance-types/{maintenanceType}', [MaintenanceTypeController::class, 'show']);

//        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('positions', [PositionController::class, 'index']);
        Route::get('positions/{position}', [PositionController::class, 'show']);

        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show']);

        Route::get('supplier-types', [SupplierTypeController::class, 'index']);
        Route::get('supplier-types/{supplierType}', [SupplierTypeController::class, 'show']);

        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);

        Route::get('working-sheets', [WorkingSheetController::class, 'index']);
        Route::get('working-sheets/{workingSheet}', [WorkingSheetController::class, 'show']);
    });
});


