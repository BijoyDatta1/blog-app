<?php

use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Middleware\TokenVerification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//home route
Route::get('/', [HomeController::class, "homePage"]);
Route::get('/aboutpage', [HomeController::class, "aboutPage"]);
Route::get('/contactpage', [HomeController::class, "contactPage"]);
Route::get('/postpage', [HomeController::class, "postPage"]);

//all admin pages all route
//dashboar
Route::get('/dashbordpage', [DashboardController::class, "dashbordPage"])->middleware(TokenVerification::class);

//category
Route::get('/categorycreatepage', [CategoryController::class, "categoryCreatePage"])->middleware(TokenVerification::class);
Route::get('/categorylistpage', [CategoryController::class, "categoryListPage"])->middleware(TokenVerification::class);


Route::post('/createcategory', [CategoryController::class, "CreateCategory"])->middleware(TokenVerification::class);
Route::post('/categoryupdate', [CategoryController::class, "CategoryUpdate"])->middleware(TokenVerification::class);
Route::post('/categorystatus', [CategoryController::class, "CategoryStatus"])->middleware(TokenVerification::class);
Route::post('/categorydelete', [CategoryController::class, "CategoryDelete"])->middleware(TokenVerification::class);
Route::get('/categorylist', [CategoryController::class, "CategoryList"])->middleware(TokenVerification::class);
Route::post('/categoryitem', [CategoryController::class, "CategoryItem"])->middleware(TokenVerification::class);

//blog
Route::get('/blogcreatepage', [BlogController::class, "blogCreatePage"])->middleware(TokenVerification::class);
Route::get('/bloglistpage', [BlogController::class, "blogListPage"])->middleware(TokenVerification::class);

//user login and auth page
Route::get('/loginpage', [AuthController::class, "logInpage"]);
Route::get('/registerpage', [AuthController::class, "registerPage"]);
Route::get('/recoverpage', [AuthController::class, 'recoverPage']);
Route::get('/otppage', [AuthController::class, "OtpPage"]);
Route::get('/resetpage', [AuthController::class, 'resetPage'])->middleware(TokenVerification::class);
Route::post('/registation', [AuthController::class, 'Registation']);
Route::post('/login', [AuthController::class, 'logIn']);
Route::post('/sendotp', [AuthController::class, 'sendOtp']);
Route::post('/verifyotp', [AuthController::class, 'verifyOtp']);
Route::post('/logout', [AuthController::class, 'logOut'])->middleware(TokenVerification::class);
Route::post('/resetpassword', [AuthController::class, 'resetPassword'])->middleware(TokenVerification::class);
