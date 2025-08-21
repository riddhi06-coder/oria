<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use Illuminate\Http\Request;



use App\Http\Controllers\Backend\SolutionsTypeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\BannerIntroController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ProjectsController;
use App\Http\Controllers\Backend\HomeSolutionsController;
use App\Http\Controllers\Backend\HomeFeaturesController;



// =========================================================================== Backend Routes

// Route::get('/', function () {
//     return view('frontend.index');
// });
  
// Authentication Routes
Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/change-password', [LoginController::class, 'change_password'])->name('admin.changepassword');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('admin.updatepassword');

Route::get('/register', [LoginController::class, 'register'])->name('admin.register');
Route::post('/register', [LoginController::class, 'authenticate_register'])->name('admin.register.authenticate');
    
// // Admin Routes with Middleware
Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
        Route::get('/dashboard', function () {
            return view('backend.dashboard'); 
        })->name('admin.dashboard');
});


// Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
//     Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
// });



// ==== Manage Solutions
Route::resource('manage-solution-type', SolutionsTypeController::class);

// ==== Manage category
Route::resource('manage-category', CategoryController::class);

// ==== Manage sub category
Route::resource('manage-sub-category', SubCategoryController::class);

// ==== Manage Banner Intro
Route::resource('manage-banner-intro', BannerIntroController::class);

// ==== Manage Gallery
Route::resource('manage-gallery', GalleryController::class);

// ==== Manage Add Proejcts
Route::resource('manage-projects', ProjectsController::class);
Route::post('/projects/update-status', [ProjectsController::class, 'updateStatus'])->name('projects.updateStatus');

// ==== Manage Our Solutions
Route::resource('manage-our-solutions', HomeSolutionsController::class);

// ==== Manage Our Features
Route::resource('manage-our-features', HomeFeaturesController::class);