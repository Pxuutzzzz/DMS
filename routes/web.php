<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\SearchController;

// Public Routes
Route::redirect('/', '/login');
Route::get('search', [SearchController::class, 'index'])->name('search.index');
Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('documents/{document}/download/{version?}', [DocumentController::class, 'download'])->name('documents.download');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Documents (Protected methods)
    Route::resource('documents', DocumentController::class)->except(['show']);
    Route::post('documents/{document}/version', [DocumentController::class, 'uploadVersion'])->name('documents.version');
    Route::post('documents/{document}/submit', [DocumentController::class, 'submit'])->name('documents.submit');
    Route::post('documents/{document}/archive', [DocumentController::class, 'archive'])->name('documents.archive');

    // Approvals (Reviewer & Super Admin)
    Route::middleware('role:'.User::ROLE_SUPER_ADMIN.','.User::ROLE_REVIEWER)->group(function () {
        Route::get('approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::post('approvals/{document}/review', [ApprovalController::class, 'review'])->name('approvals.review');
        Route::post('approvals/{document}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('approvals/{document}/revision', [ApprovalController::class, 'requestRevision'])->name('approvals.revision');
    });

    // Categories (Admin, Super Admin, Biro)
    Route::middleware('role:'.User::ROLE_SUPER_ADMIN.','.User::ROLE_ADMIN.','.User::ROLE_BIRO)->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

    // Archives (Admin, Super Admin, Biro)
    Route::middleware('role:'.User::ROLE_SUPER_ADMIN.','.User::ROLE_ADMIN.','.User::ROLE_BIRO)->group(function () {
        Route::get('archives', [ArchiveController::class, 'index'])->name('archives.index');
        Route::post('archives/{document}/restore', [ArchiveController::class, 'restore'])->name('archives.restore');
    });

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Super Admin & Biro
    Route::middleware('role:'.User::ROLE_SUPER_ADMIN.','.User::ROLE_BIRO)->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Super Admin Only
    Route::middleware('role:'.User::ROLE_SUPER_ADMIN)->group(function () {
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });
});

require __DIR__.'/auth.php';
