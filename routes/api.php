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

//        TODO:
//          -TEST ASSERT FIELDS IN LIST RESOURCES
        Route::get('articles', [ArticleController::class, 'index']);
        Route::get('article-types', [ArticleTypeController::class, 'index']);
        Route::get('attendance-sheets', [AttendanceSheetController::class, 'index']);
        Route::get('banks', [BankController::class, 'index']);
        Route::get('document-types', [DocumentTypeController::class, 'index']);
        Route::get('employees', [EmployeeController::class, 'index']);
        Route::get('images', [ImageController::class, 'index']);
        Route::get('machines', [MachineController::class, 'index']);
        Route::get('maintenance-sheets', [MaintenanceSheetController::class, 'index']);
        Route::get('maintenance-types', [MaintenanceTypeController::class, 'index']);
//        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('positions', [PositionController::class, 'index']);
        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('supplier-types', [SupplierTypeController::class, 'index']);
        Route::get('users', [UserController::class, 'index']);
        Route::get('working-sheets', [WorkingSheetController::class, 'index']);
    });
});


