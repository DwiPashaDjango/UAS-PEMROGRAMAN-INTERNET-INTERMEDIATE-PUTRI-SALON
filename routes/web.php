<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignerController;
use App\Http\Controllers\Admin\ListRentedController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\ForgotPassword;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\AccountController;
use App\Http\Controllers\Pages\CartController;
use App\Http\Controllers\Pages\CommentController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ProductController;
use App\Http\Controllers\Pages\RentController;
use App\Http\Controllers\Pages\RentedController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/abouts', [AboutController::class, 'index'])->name('about');
Route::get('/contacts', [ContactController::class, 'index'])->name('contact');
Route::get('/accounts', [AccountController::class, 'index'])->name('account');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/check', [LoginController::class, 'login'])->name('login.check');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register/check', [RegisterController::class, 'register'])->name('register.check');

Route::get('/forgot', [ForgotPassword::class, 'index'])->name('forgot.password');

Route::get('/ordered/{title}/{message}', function ($title, $message) {
    return view('components.success', compact('message', 'title'));
})->name('alert.rent');


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product');
    Route::get('{id}/see', [ProductController::class, 'show'])->name('product.show');
    Route::post('/save/whislist', [ProductController::class, 'saveWhislist'])->name('product.save.whislist');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['role:Admin|Pengguna']);
    Route::put('/update-account/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::put('/update-profile/{id}', [AccountController::class, 'updateAccount'])->name('account.profile');

    Route::prefix('admins')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:Admin']);
        Route::post('/statistikRent', [DashboardController::class, 'statistikRent'])->name('dashboard.statistikRent')->middleware(['role:Admin']);

        Route::prefix('designers')->group(function () {
            Route::get('/', [DesignerController::class, 'index'])->name('designer');
            Route::get('/show/{id}', [DesignerController::class, 'show'])->name('designer.show');
            Route::post('/store', [DesignerController::class, 'store'])->name('designer.store');
            Route::post('/update', [DesignerController::class, 'update'])->name('designer.update');
            Route::delete('/destroy/{id}', [DesignerController::class, 'destroy'])->name('designer.destroy');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('admin.product');
            Route::get('/create', [AdminProductController::class, 'create'])->name('admin.product.create');
            Route::post('/store', [AdminProductController::class, 'store'])->name('admin.product.store');
            Route::get('/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
            Route::put('/{id}/update', [AdminProductController::class, 'update'])->name('admin.product.update');
            Route::delete('/destroy/{id}', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
        });

        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.order');
            Route::get('/{invoice}/details', [OrderController::class, 'show'])->name('admin.order.show');
            Route::get('/{invoice}/invoice', [OrderController::class, 'generateInvoice'])->name('admin.order.generateInvoice');
            Route::put('/{id}/confirmationSendingPackage', [OrderController::class, 'confirmationSendingPackage'])->name('admin.order.confirmationSendingPackage');
        });

        Route::prefix('renteds')->group(function () {
            Route::get('/', [ListRentedController::class, 'index'])->name('admin.rented');
            Route::get('/{invoice}/details', [ListRentedController::class, 'show'])->name('admin.rented.show');
        });

        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('admin.report');
            Route::get('/renteds', [ReportController::class, 'rented'])->name('admin.report.rented');
            Route::get('/{month}/{years}/printReportRent', [ReportController::class, 'printReportRent'])->name('admin.report.printReportRent');
            Route::get('/{month}/{years}/printReportRented', [ReportController::class, 'printReportRented'])->name('admin.report.printReportRented');
        });
    });

    Route::prefix('rents')->group(function () {
        Route::get('/{invoice}', [RentController::class, 'index'])->name('rent');
        Route::post('/generateRent', [RentController::class, 'generateRent'])->name('users.generateRent');
        Route::put('/updatePaidRent/{invoice}', [RentController::class, 'updatePaidRent'])->name('users.updatePaidRent');
        Route::get('/invoice/{invoice}/rents', [RentController::class, 'generateRentInvoice'])->name('rent.generateRentInvoice');
    });

    Route::prefix('renteds')->group(function () {
        Route::get('/', [RentedController::class, 'index'])->name('rented');
        Route::get('/renteds/{invoice}/return', [RentedController::class, 'show'])->name('rented.show');
        Route::post('/return', [RentedController::class, 'returnRents'])->name('rent.returnRents');
        Route::delete('/canceled/{id}', [RentedController::class, 'canceled'])->name('rent.canceled');
        Route::get('/invoice/{invoice}/rents', [RentedController::class, 'generateRentInvoice'])->name('rent.generateRentInvoice');
        Route::get('/invoice/{invoice}/returns', [RentedController::class, 'generateReturnInvoice'])->name('rent.generateReturnInvoice');
    });

    Route::prefix('whislists')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('whislist');
        Route::get('/getWhislist', [CartController::class, 'getWhislist'])->name('whislist.getWhislist');
        Route::get('/show/{id}', [CartController::class, 'show'])->name('whislist.show');
        Route::post('/generateRent', [CartController::class, 'generateRent'])->name('whislist.generateRent');
        Route::put('/incrase/{id}', [CartController::class, 'incrase'])->name('whislist.incrase');
        Route::put('/decrease/{id}', [CartController::class, 'decrease'])->name('whislist.decrease');
        Route::delete('/destroy/{id}', [CartController::class, 'destroy'])->name('whislist.destroy');
    });
});

Route::prefix('comment')->group(function () {
    Route::get('/loadMoreComment', [CommentController::class, 'show'])->name('product.comment');
    Route::post('/store', [CommentController::class, 'store'])->name('product.store');
});
