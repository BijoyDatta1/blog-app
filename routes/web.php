<?php

use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Home\HomeController;
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

//admin pages
Route::get('/dashbordpage', [DashboardController::class, "dashbordPage"]);
Route::get('/categorycreatepage', [CategoryController::class, "categoryCreatePage"]);
Route::get('/categorylistpage', [CategoryController::class, "categoryListPage"]);
Route::get('/blogcreatepage', [BlogController::class, "blogCreatePage"]);
Route::get('/bloglistpage', [BlogController::class, "blogListPage"]);
