<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Guest routes for admins
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/check-login', [AuthController::class, 'checkLogin'])->name('check.login');

    Route::get('/adm-login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('/adm-check-login', [AuthController::class, 'adminCheckLogin'])->name('admin.check.login');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //customer route
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.list');
    Route::get('/customer-active', [CustomerController::class, 'active'])->name('customer.active');
    Route::get('/customer-inactive', [CustomerController::class, 'inactive'])->name('customer.inactive');
    Route::get('/customer-create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer-show/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/customer-status/{id}', [CustomerController::class, 'status'])->name('customer.status');
    Route::get('/customer-edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('/customer-destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::post('/customer-update', [CustomerController::class, 'update'])->name('customer.update');

    //Invoice route
    Route::get('/invoice-list', [InvoiceController::class, 'index'])->name('invoice.list');
    Route::get('/invoice-create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice-store', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice-paid', [InvoiceController::class, 'paid'])->name('invoice.paid');
    Route::get('/invoice-unpaid', [InvoiceController::class, 'unpaid'])->name('invoice.unpaid');

    Route::get('/invoice-show/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice-status/{id}', [InvoiceController::class, 'status'])->name('invoice.status');
    Route::get('/invoice-edit/{id}', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::get('/invoice-destroy/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::post('/invoice-update/{id}', [InvoiceController::class, 'update'])->name('invoice.update');

    Route::get('/invoice-customer-get', [InvoiceController::class, 'getCustomer'])->name('get.customer');
    Route::get('/invoice-invoice-get', [InvoiceController::class, 'getInvoice'])->name('get.invoice');
    Route::get('/payment-invoice-get', [InvoiceController::class, 'paymentInvoice'])->name('payment.invoice');
    Route::get('/payment-invoice-download/{id}', [InvoiceController::class, 'download'])->name('invoice.download');

    //payment 
    Route::post('/inv-payment', [PaymentController::class, 'store'])->name('payment');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payment.list');

    //for customer report
    Route::get('/report', [InvoiceController::class, 'report'])->name('report.list');
    Route::get('/report-payment-history', [InvoiceController::class, 'paymentHistory'])->name('report.payment.history');

    //company route
    Route::get('companies', [CompanyController::class, 'index'])->name('company.index');
    Route::post('company-update', [CompanyController::class, 'update'])->name('company.update');

    //profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile-update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile-password', [DashboardController::class, 'changePassword'])->name('change.password');
    Route::post('/profile-password-update', [DashboardController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});