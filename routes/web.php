<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AmenityController;
use App\Http\Controllers\Dashboard\AppSettingController;
use App\Http\Controllers\Dashboard\AreaController;
use App\Http\Controllers\Dashboard\CareerController;
use App\Http\Controllers\Dashboard\CashDiscountController;
use App\Http\Controllers\Dashboard\CompoundController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\DeveloperController;
use App\Http\Controllers\Dashboard\DownPaymentController;
use App\Http\Controllers\Dashboard\InfoPageController;
use App\Http\Controllers\Dashboard\InstallmentController;
use App\Http\Controllers\Dashboard\LaunchController;
use App\Http\Controllers\Dashboard\MediaFolderController;
use App\Http\Controllers\Dashboard\MeetingController;
use App\Http\Controllers\Dashboard\PaymentComponentController;
use App\Http\Controllers\Dashboard\PaymentPlanController;
use App\Http\Controllers\Dashboard\PropertyController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SellRequestController;
use App\Http\Controllers\HomeController;
use App\Models\Admin;
use App\Models\InfoPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// landing pages

Route::group(['middleware' => ['localization']], function () {
    Route::redirect('/admin', '/login');

    Auth::routes();
    Auth::routes(['register' => false]);
    Route::get('/admin/home', function () {
        if (session('status')) {
            return redirect()->route('admin.home')->with('status', session('status'));
        }

        return redirect()->route('admin.home');
    })->name('admin.home');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('admins.logout');
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('lang/change', function () {
            $user = Admin::find(auth('')->user()->id);
            $user->locale = $user->locale == 'ar' ? 'en' : 'ar';
            $user->save();
            return redirect()->back();
        })->name('changeLang');

        // Admins
        Route::resource('admins', AdminController::class);
        Route::put('/admins/{id}/toggleActivity', [AdminController::class, 'toggleActivity'])->name('admins.toggleActivity');
        Route::get('/admins/{id}/permissions', [AdminController::class, 'permissions'])->name('admins.permissions');
        Route::post('/admins/{id}/updatePermissions', [AdminController::class, 'updatePermissions'])->name('admins.updatePermissions');

        // Roles
        Route::resource('roles', RoleController::class);
        Route::get('/roles/{id}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('/roles/{id}/updatePermissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

        // InfoPages
        Route::resource('info_pages', InfoPageController::class);
        Route::put('/info_pages/{id}/toggleActivity', [InfoPageController::class, 'toggleActivity'])->name('info_pages.toggleActivity');

        // end
    });
});
