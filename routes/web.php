<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserChangePassword;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth'])->group(function () {
    //books
    Route::get('book/create', [BookController::class, 'create'])->name('books.create');
    Route::post('book/store', [BookController::class, 'store'])->name('books.store');
    Route::get('user/books', [BookController::class, 'index'])->name('user.books.list');
    Route::get('user/books/{book:slug}/edit', [BookController::class, 'edit'])->name('user.books.edit');
    Route::put('user/books/{book:slug}', [BookController::class, 'update'])->name('user.books.update');
    Route::delete('user/books/{book}', [BookController::class, 'destroy'])->name('user.books.destroy');
    // Route::resource('books', BookController::class); 

    //books report
    Route::get('book/{book:slug}/report/create', [BookReportController::class, 'create'])->name('books.report.create');
    Route::post('book/{book}/report', [BookReportController::class, 'store'])->name('books.report.store');

    //order
    Route::get('user/orders', [OrderController::class, 'index'])->name('user.orders.index');

    //User Settings
    Route::get('user/settings', [UserSettingsController::class, 'index'])->name('user.settings');
    Route::post('user/settings/{user}', [UserSettingsController::class, 'update'])->name('user.settings.update');
    Route::post('user/settings/password/change/{user}', [UserChangePassword::class, 'update'])->name('user.password.update');
});


Route::get('book/{book:slug}', [BookController::class, 'show'])->name('books.show');


Route::middleware(['isAdmin'])->group(function () {
    Route::get('admin', AdminDashboardController::class)->name('admin.index');

    Route::get('admin/books', [AdminBookController::class, 'index'])->name('admin.books.index');
    Route::get('admin/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
    Route::post('admin/books', [AdminBookController::class, 'store'])->name('admin.books.store');
    Route::get('admin/books/{book}/edit', [AdminBookController::class, 'edit'])->name('admin.books.edit');
    Route::put('admin/books/{book}', [AdminBookController::class, 'update'])->name('admin.books.update');
    Route::delete('admin/books/{book}', [AdminBookController::class, 'destroy'])->name('admin.books.destroy');
    Route::put('admin/book/approve/{book}', [AdminBookController::class, 'approveBook'])->name('admin.books.approve');

    Route::get('admin/users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/{user}/edit', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [AdminUsersController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__ . '/auth.php';
