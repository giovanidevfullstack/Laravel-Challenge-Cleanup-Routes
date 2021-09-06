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

Route::get('/', HomeController::class)->name('home');

Route::get('book/create', [BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('book/store', [BookController::class, 'store'])->middleware('auth')->name('books.store');
Route::get('book/{book:slug}/report/create', [BookReportController::class, 'create'])->middleware('auth')->name('books.report.create');
Route::post('book/{book}/report', [BookReportController::class, 'store'])->middleware('auth')->name('books.report.store');
Route::get('book/{book:slug}', [BookController::class, 'show'])->name('books.show');

Route::get('user/books', [BookController::class, 'index'])->middleware('auth')->name('user.books.list');
Route::get('user/books/{book:slug}/edit', [BookController::class, 'edit'])->middleware('auth')->name('user.books.edit');
Route::put('user/books/{book:slug}', [BookController::class, 'update'])->middleware('auth')->name('user.books.update');
Route::delete('user/books/{book}', [BookController::class, 'destroy'])->middleware('auth')->name('user.books.destroy');

Route::get('user/orders', [OrderController::class, 'index'])->middleware('auth')->name('user.orders.index');

Route::get('user/settings', [UserSettingsController::class, 'index'])->middleware('auth')->name('user.settings');
Route::post('user/settings/{user}', [UserSettingsController::class, 'update'])->middleware('auth')->name('user.settings.update');
Route::post('user/settings/password/change/{user}', [UserChangePassword::class, 'update'])->middleware('auth')->name('user.password.update');

Route::get('admin', \App\Http\Controllers\Admin\AdminDashboardController::class)->middleware('isAdmin')->name('admin.index');

Route::get('admin/books', [AdminBookController::class, 'index'])->middleware('isAdmin')->name('admin.books.index');
Route::get('admin/books/create', [AdminBookController::class, 'create'])->middleware('isAdmin')->name('admin.books.create');
Route::post('admin/books', [AdminBookController::class, 'store'])->middleware('isAdmin')->name('admin.books.store');
Route::get('admin/books/{book}/edit', [AdminBookController::class, 'edit'])->middleware('isAdmin')->name('admin.books.edit');
Route::put('admin/books/{book}', [AdminBookController::class, 'update'])->middleware('isAdmin')->name('admin.books.update');
Route::delete('admin/books/{book}', [AdminBookController::class, 'destroy'])->middleware('isAdmin')->name('admin.books.destroy');
Route::put('admin/book/approve/{book}', [AdminBookController::class, 'approveBook'])->middleware('isAdmin')->name('admin.books.approve');

Route::get('admin/users', [AdminUsersController::class, 'index'])->middleware('isAdmin')->name('admin.users.index');
Route::get('admin/users/{user}/edit', [AdminUsersController::class, 'edit'])->middleware('isAdmin')->name('admin.users.edit');
Route::put('admin/users/{user}', [AdminUsersController::class, 'update'])->middleware('isAdmin')->name('admin.users.update');
Route::delete('admin/users/{user}', [AdminUsersController::class, 'destroy'])->middleware('isAdmin')->name('admin.users.destroy');

require __DIR__ . '/auth.php';
