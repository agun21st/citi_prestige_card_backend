<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\SubCategoriesController;

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
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/checkUserLoginStatus', [AuthController::class, 'checkUserLoginStatus']);
// Route::get('/reset-password', [AuthController::class, 'resetPasswordLink'])->name('resetPasswordLink');
// frontend route
Route::get('/frontendApi/getAlldepartmentsTools', [DepartmentsController::class, 'getAlldepartmentsTools']);
Route::get('/frontendApi/departments', [DepartmentsController::class, 'getDepartmentsForFrontend']);
Route::get('/frontendApi/department/{id}', [DepartmentsController::class, 'getDepartmentByIdForFrontend']);
Route::get('/frontendApi/toolsByCourseForFrontend/{id}', [ToolsController::class, 'toolsByCourseForFrontend']);
Route::get('/frontendApi/latestTools', [ToolsController::class, 'getLatestToolsForFrontend']);
Route::get('/frontendApi/popularTools', [ToolsController::class, 'getPopularToolsForFrontend']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        // return $request->user()->load('courses');
        return $request->user();
    });
    Route::get('/check-userId/{userId}/{id}', [AuthController::class, 'checkUserId']);
    Route::get('/reCheck-userId/{userId}/{id}', [AuthController::class, 'reCheckUserId']);
    // Admin Create
    Route::post('/create-admin', [AuthController::class, 'createAdmin']);
    Route::get('/get-admins/{id}', [AuthController::class, 'getAdmins']);
    Route::patch('/update-admin/{id}', [AuthController::class, 'updateAdmin']);
    Route::delete('/delete-admin/{id}', [AuthController::class, 'deleteAdmin']);

    // Student Create
    Route::get('/check-student-Login_id/{studentLogin_id}', [AuthController::class, 'checkStudentLoginId']);
    Route::get('/get-students', [AuthController::class, 'getStudents']);
    Route::delete('/delete-student-login-details/{id}', [AuthController::class, 'studentLoginDetails']);
    Route::post('/create-student', [AuthController::class, 'createStudent']);
    Route::patch('/update-student/{id}', [AuthController::class, 'updateStudent']);
    Route::patch('/update-user-from-profile/{id}', [AuthController::class, 'updateUserFromProfile']);
    Route::delete('/delete-student/{id}', [AuthController::class, 'deleteStudent']);
    // Department Route
    Route::resource('enrollments', EnrollmentsController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Department Route
    Route::resource('departments', DepartmentsController::class);
    // Courses Route
    Route::resource('courses', CoursesController::class);
    // Categories Route
    Route::resource('categories', CategoriesController::class);
    // Brands Route
    Route::resource('brands', BrandsController::class);
    // Locations Route
    Route::resource('locations', LocationsController::class);
    // Offers Route
    Route::resource('offers', OffersController::class);
    // Tools Route
    Route::resource('tools', ToolsController::class);
    Route::get('/tools-subCategories/{id}', [ToolsController::class, 'getSubCategories']);
    Route::get('/get-tools-by-course/{id}', [ToolsController::class, 'getToolsForStudents']);

    // students Route
    Route::resource('students', StudentsController::class);
});
