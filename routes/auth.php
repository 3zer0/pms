<?php

use App\Models\Office;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\Auth\PtrController;
use App\Http\Controllers\Auth\ItemController;
use App\Http\Controllers\Auth\QrCodeController;
use App\Http\Controllers\Auth\ReportController;
use App\Http\Controllers\Auth\ArticleController;
use App\Http\Controllers\Auth\CategoryController;
use App\Http\Controllers\Auth\DeliveryController;
use App\Http\Controllers\Auth\SupplierController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest')
                ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');


/**--------------------------------------------------
 * TODO: Authenticated Pages
 *---------------------------------------------------*/

Route::middleware([ 'nAuth:pages' ])->group(function() {

    //! Dashboard
    Route::get('/dashboard', function() {
        return view('pages.dashboard');
    })->name('pg.dashboard');

    //! User
    Route::get('/users', [ RegisteredUserController::class, 'index' ])->name('pg.users');

    //! Supplier
    Route::get('/suppliers', [ SupplierController::class, 'index' ])->name('pg.suppliers');

    //! Delivery
    Route::get('/deliveries', [ DeliveryController::class, 'index' ])->name('pg.deliveries');

    //! Item
    Route::get('/items', [ ItemController::class, 'index' ])->name('pg.items');

    //! PTR
    Route::get('/ptrs', [ PtrController::class, 'index' ])->name('pg.ptrs');

    //! Article
    Route::get('/articles', [ ArticleController::class, 'index' ])->name('pg.articles');

    //! Category
    Route::get('/categories', [ CategoryController::class, 'index' ])->name('pg.categories');

    //! Reports
    Route::get('/reports/ipa', [ ReportController::class, 'ipa' ])->name('pg.rep_ipa');
    Route::get('/reports/pa', [ ReportController::class, 'pa' ])->name('pg.rep_pa');
    Route::get('/reports/pc', [ ReportController::class, 'pc' ])->name('pg.rep_pc');
    Route::get('/reports/ppe', [ ReportController::class, 'ppe' ])->name('pg.rep_ppe');
    Route::get('/reports/sep', [ ReportController::class, 'sep' ])->name('pg.rep_sep');

});

/**--------------------------------------------------
 * TODO: Authenticated API
 *---------------------------------------------------*/

Route::middleware([ 'nAuth:response' ])->group(function() {

    //! ---> User
    //? [GET]
    Route::get('/user/dt', [ RegisteredUserController::class, 'dt_users' ])->name('user.dt');

    //? [POST]
    Route::post('/user/create', [ RegisteredUserController::class, 'store' ])->name('user.create');
    Route::post('/user/{id}/edit', [ RegisteredUserController::class, 'edit' ])->name('user.edit');
    Route::post('/user/{id}/delete', [ RegisteredUserController::class, 'delete' ])->name('user.delete');
    Route::get('/user/validate/username', [ RegisteredUserController::class, 'validate_username' ]);
    Route::get('/user/validate/email', [ RegisteredUserController::class, 'validate_email' ]);
    Route::get('/user/validate/mobile_no', [ RegisteredUserController::class, 'validate_mobile_no' ]);

    //! ---> Supplier
    //? [GET]
    Route::get('/supplier/dt', [ SupplierController::class, 'dt_suppliers' ])->name('supplier.dt');

    //? [POST]
    Route::post('/supplier/create', [ SupplierController::class, 'store' ])->name('supplier.create');
    Route::post('/supplier/{id}/edit', [ SupplierController::class, 'edit' ])->name('supplier.edit');
    Route::post('/supplier/{id}/delete', [ SupplierController::class, 'delete' ])->name('supplier.delete');
    Route::get('/supplier/validate/sup_name', [ SupplierController::class, 'validate_suppliername' ]);

    //! ---> Delivery
    //? [GET]
    Route::get('/delivery/dt', [ DeliveryController::class, 'dt_deliveries' ])->name('delivery.dt');

    //? [POST]
    Route::post('/delivery/create', [ DeliveryController::class, 'store' ])->name('delivery.create');
    Route::post('/delivery/{id}/edit', [ DeliveryController::class, 'edit' ])->name('delivery.edit');
    Route::post('/delivery/{id}/delete', [ DeliveryController::class, 'delete' ])->name('delivery.delete');

    //! ---> Items
    //? [GET]
    Route::get('/item/dt', [ ItemController::class, 'dt_items' ])->name('item.dt');
    Route::get('/item/{id}/det', [ ItemController::class, 'ptr_det' ])->name('det.dt');
    Route::get('/item/{id}/print', [ItemController::class, 'print_items'])->name('item.print');
    Route::get('/item/{id}/qr', [ItemController::class, 'generateQrCode'])->name('item.qr');

    //? [POST]
    Route::post('/item/create', [ ItemController::class, 'store' ])->name('item.create');
    Route::post('/item/{id}/edit', [ ItemController::class, 'edit' ])->name('item.edit');
    Route::post('/item/{id}/delete', [ ItemController::class, 'delete' ])->name('item.delete');

    //! ---> PTR
    //? [GET]
    Route::get('/ptr/dt', [ PtrController::class, 'dt_ptr' ])->name('ptr.dt');
    Route::get('/ptr/{id}/print', [PtrController::class, 'print_ptr'])->name('ptr.print');
    Route::get('/ptr/{id}/qr', [PtrController::class, 'generateQrCode'])->name('ptr.qr');

    //? [POST]
    Route::post('/ptr/create', [ PtrController::class, 'store' ])->name('ptr.create');
    Route::post('/ptr/{id}/edit', [ PtrController::class, 'edit' ])->name('ptr.edit');
    Route::post('/ptr/{id}/delete', [ PtrController::class, 'delete' ])->name('ptr.delete');

    //! ---> ITR
    //? [GET]
    Route::get('/itr/dt', [ PtrController::class, 'dt_itr' ])->name('itr.dt');
    Route::get('/itr/{id}/print', [PtrController::class, 'print_itr'])->name('itr.print');
    Route::get('/itr/{id}/qr', [PtrController::class, 'generateQrCode'])->name('itr.qr');

    //? [POST]
    Route::post('/itr/create', [ PtrController::class, 'store' ])->name('itr.create');
    Route::post('/itr/{id}/edit', [ PtrController::class, 'edit' ])->name('itr.edit');
    Route::post('/itr/{id}/delete', [ PtrController::class, 'delete' ])->name('itr.delete');

    //! ---> Article
    //? [GET]
    Route::get('/article/dt', [ ArticleController::class, 'dt_articles' ])->name('article.dt');

    //? [POST]
    Route::post('/article/create', [ ArticleController::class, 'store' ])->name('article.create');
    Route::post('/article/{id}/edit', [ ArticleController::class, 'edit' ])->name('article.edit');
    Route::post('/article/{id}/delete', [ ArticleController::class, 'delete' ])->name('article.delete');

    //! ---> Category
    //? [GET]
    Route::get('/category/dt', [ CategoryController::class, 'dt_categories' ])->name('category.dt');

    // //? [POST]
    Route::post('/category/create', [ CategoryController::class, 'store' ])->name('category.create');
    Route::post('/category/{id}/edit', [ CategoryController::class, 'edit' ])->name('category.edit');
    Route::post('/category/{id}/delete', [ CategoryController::class, 'delete' ])->name('category.delete');

    //! Cluster/Offices/Divisions
    Route::get('/division/search', [ OfficeController::class, 'division_search' ]);
    Route::get('/office/search', [ OfficeController::class, 'office_search' ]);
    Route::get('/employee/search', [ItemController::class, 'get_employee']);

    //! ---> QR code
    //? [GET]
    Route::get('/qrcode', [ QrCodeController::class, 'generateQrCode' ])->name('qrcode.dt');

    //! ---> Reports
    //? [GET]
    Route::get('/reports/dt', [ ReportController::class, 'dt_reports' ])->name('report.dt');
    Route::get('/reports/check-items-ipa', [ReportController::class, 'checkItemsIpa']);
    Route::get('/reports/check-items-pa', [ReportController::class, 'checkItemsPa']);
    Route::get('/reports/check-items-pc', [ReportController::class, 'checkItemsPc']);
    Route::get('/reports/check-items-ppe', [ReportController::class, 'checkItemsPpe']);
    Route::get('/reports/check-items-sep', [ReportController::class, 'checkItemsSep']);
    Route::get('/reports/print/ipa', [ReportController::class, 'print_report_ipa'])->name('report.print');
    Route::get('/reports/print/pa', [ReportController::class, 'print_report_pa'])->name('report.print');
    Route::get('/reports/print/pc', [ReportController::class, 'print_report_pc'])->name('report.print');
    Route::get('/reports/print/ppe', [ReportController::class, 'print_report_ppe'])->name('report.print');
    Route::get('/reports/print/sep', [ReportController::class, 'print_report_sep'])->name('report.print');

});
