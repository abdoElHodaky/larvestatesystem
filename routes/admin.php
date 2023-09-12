<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPasswordResetController;

use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostEnquiryController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\RemittanceController;
use App\Http\Controllers\Admin\SearchRemitController;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){

    Route::get('login', [AdminController::class, 'index'])->name('login.index');
    Route::post('login', [AdminController::class, 'login'])->name('login');

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('admin');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout')->middleware('admin');

    // Forgot/Reset password
    Route::get('forgot-password', [AdminPasswordResetController::class, 'create'])->name('forgot-password');
    Route::post('forgot-password', [AdminPasswordResetController::class, 'sendResetLink'])->name('forgot-password.send');

    Route::get('reset-password/{token}', [AdminPasswordResetController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password', [AdminPasswordResetController::class, 'handleResetPassword'])->name('reset-password.send');

    // This route is for the admin Dashboard page Controller
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // This route is for the PropertyController
    Route::resource('property', PropertyController::class);

    // This route is for the BlogController
    Route::resource('blog', BlogController::class);

    // This route is for the PostEnquireController
    Route::resource('post-enquiry', PostEnquiryController::class);

    // This route is for the AboutUs Controller
    Route::resource('about', AboutController::class);

    // This route is for the PostEnquireController
    Route::resource('agent', AgentController::class);

    // This route is for the RemittanceController
    Route::resource('remit', RemittanceController::class);

    // This route is for the search functionality in the Remittance admin page
    Route::get('search', [SearchRemitController::class, 'search'])->name('remit.search');

});

