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
use App\Http\Controllers\Admin\SearchPropertyController;
use App\Http\Controllers\Admin\TenantRecordController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;


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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('admin');

    // This route is for the PropertyController
    Route::resource('property', PropertyController::class)->middleware('admin');

    // This route is for the BlogController
    Route::resource('blog', BlogController::class)->middleware('admin');

    // This route is for the PostEnquireController
    Route::resource('post-enquiry', PostEnquiryController::class)->middleware('admin');

    // This route is for the AboutUs Controller
    Route::resource('about', AboutController::class)->middleware('admin');

    // This route is for the PostEnquireController
    Route::resource('agent', AgentController::class)->middleware('admin');

    // This route is for the RemittanceController
    Route::resource('remit', RemittanceController::class)->middleware('admin');

    // This route is for the search functionality in the Remittance admin page
    Route::get('search-remit', [SearchRemitController::class, 'search'])->name('remit.search')->middleware('admin');
    // This route is for the search functionality in the Properties admin page
    Route::get('search-property', [SearchPropertyController::class, 'search'])->name('property.search')->middleware('admin');

    // Thess routes are for the TenantRecordController
    Route::get('statement', [TenantRecordController::class, 'index'])->name('statement.index')->middleware('admin');
    Route::get('statement/create', [TenantRecordController::class, 'create'])->name('statement.create')->middleware('admin');
    Route::get('statement/generate-pdf', [TenantRecordController::class, 'generatePDF'])->name('statement.generate-pdf')->middleware('admin');
    Route::get('statement/generate-excel', [TenantRecordController::class, 'generateExcel'])->name('statement.generate-excel')->middleware('admin');

    // This route is for Roles and Permission Controller
    Route::get('role', [RolePermissionController::class, 'index'])->name('role.index')->middleware('admin')->middleware('admin');
    Route::get('role/create', [RolePermissionController::class, 'create'])->name('role.create')->middleware('admin')->middleware('admin');
    Route::post('role/store', [RolePermissionController::class, 'store'])->name('role.store')->middleware('admin')->middleware('admin');
    Route::get('role/{role}/edit', [RolePermissionController::class, 'edit'])->name('role.edit')->middleware('admin')->middleware('admin');
    Route::put('role/{role}', [RolePermissionController::class, 'update'])->name('role.update')->middleware('admin')->middleware('admin');
    Route::delete('role/{role}', [RolePermissionController::class, 'destroy'])->name('role.destroy')->middleware('admin')->middleware('admin');

    // Admin User Roles
    Route::resource('role-user', RoleUserController::class)->middleware('admin');

});

