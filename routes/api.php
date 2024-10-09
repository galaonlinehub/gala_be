<?php

use App\Http\Controllers\K12\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Book\BookCategoryController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\K12\EducationProgrammeController;
use App\Http\Controllers\K12\LevelController;
use App\Http\Controllers\K12\SubjectController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


// login and register

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('login/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
Route::post('mobile-login/{provider}', [AuthController::class, 'mobileLogin']);

// email verification

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email sent successfully'], 200);
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();  // 
    return response()->json(['message' => 'Email successfully verified'], 200);
})->middleware(['auth:api', 'signed'])->name('verification.verify');


Route::get('/email/verify-status', function (Request $request) {
    return response()->json(['verified' => $request->user()->hasVerifiedEmail()], 200);
})->middleware('auth:sanctum');

// password reset
Route::post('/password/email', [PasswordResetLinkController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/countries', [AddressController::class, 'index']);

// university routes

Route::get('/universities', [UniversityController::class, 'index']);
Route::post('/university', [UniversityController::class, 'store']);

Route::get('/colleges', [CollegeController::class, 'index']);
Route::post('/college', [CollegeController::class, 'store']);

Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/department', [DepartmentController::class, 'store']);

Route::get('/course_programmes', [ProgrammeController::class, 'index']);
Route::post('/course_programme', [ProgrammeController::class, 'store']);

// Route::middleware(['auth:api','verified'])->group(function(){

// });


// books
Route::post('book_category', [BookCategoryController::class,'store']);
Route::get('book_categories', [BookCategoryController::class,'index']);

Route::get('book/{book}', [BookController::class,'show']);
Route::get('categories_books', [BookController::class,'index']);
Route::get('category_books/{bookCategory}', [BookController::class,'showCategoryBooks']);

// K12 routes
Route::prefix('/k12')->group(function(){
    // subjects
    Route::get('/subjects',[SubjectController::class,'index']);
    Route::post('/subjects',[SubjectController::class,'store']);
    Route::get('subjects/{level}',[SubjectController::class,'levelSubjects']);

    // levels
    Route::get('/levels',[LevelController::class,'index']);
    Route::post('/levels',[LevelController::class,'store']);
    
    // education programme
    Route::get('/education_programmes',[EducationProgrammeController::class,'index']);
    Route::post('/education_programme',[EducationProgrammeController::class,'store']);

    // grade
    Route::get('/grades',[GradeController::class,'index']);
    Route::get('/grades/{level}',[GradeController::class,'levelGrades']);
    Route::post('/grade',[GradeController::class,'store']);


});
