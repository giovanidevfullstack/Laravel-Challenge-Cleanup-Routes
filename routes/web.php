<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    BookController,
    BookReportController,
    OrderController,
    UserSettingsController,
    UserChangePassword
};
use App\Http\Controllers\Admin\{
    AdminBookController,
    AdminUsersController,
    AdminDashboardController
};

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth'])->group(function () {
    //Books
    Route::name('books.')->group(function () {
        //Books
        Route::get('book/create', [BookController::class, 'create'])->name('create');
        Route::post('book/store', [BookController::class, 'store'])->name('store');

        //Reports
        Route::get('book/{book:slug}/report/create', [BookReportController::class, 'create'])->name('report.create');
        Route::post('book/{book}/report', [BookReportController::class, 'store'])->name('report.store');
    });

    //User Routes
    Route::name('user.')->group(function () {
        //Books
        Route::get('user/books', [BookController::class, 'index'])->name('books.list');
        Route::get('user/books/{book:slug}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('user/books/{book:slug}', [BookController::class, 'update'])->name('books.update');
        Route::delete('user/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
        //Route::resource('books', BookController::class)->only(['edit', 'update', 'destroy']);
        
        //Settings
        Route::get('user/settings', [UserSettingsController::class, 'index'])->name('settings');
        Route::post('user/settings/{user}', [UserSettingsController::class, 'update'])->name('settings.update');
        Route::post('user/settings/password/change/{user}', [UserChangePassword::class, 'update'])->name('password.update');

        //Orders
        Route::get('user/orders', [OrderController::class, 'index'])->name('orders.index');
    });
});

Route::get('book/{book:slug}', [BookController::class, 'show'])->name('books.show');

//Admin Routes
Route::middleware(['isAdmin'])->group(function () {
    Route::get('admin', AdminDashboardController::class)->name('admin.index');

    Route::name('admin.')->group(function () {
        Route::put('admin/book/approve/{book}', [AdminBookController::class, 'approveBook'])->name('books.approve');
        Route::resource('books', AdminBookController::class); 
        Route::resource('users', AdminUsersController::class); 
    });
});

require __DIR__ . '/auth.php';
