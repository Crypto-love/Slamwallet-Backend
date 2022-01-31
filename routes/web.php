<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\SendBulkMailController;
// use App\Http\Controllers\SendMailController;
use App\Http\Controllers\SendBulkMailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user())
        return redirect('/home');

    return view('auth.login');
});

// Auth::routes(['verify' => true]);
Auth::routes();
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
// Route::get('/signup', [App\Http\Controllers\RegisterController::class, 'signup'])->name('signup');

// admin
Route::get('/admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/profile/{user_id}', [App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
Route::get('/admin/destroy/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
Route::get('/admin/setting', [App\Http\Controllers\AdminController::class, 'setting'])->name('admin.setting');
Route::post('/admin/setting/update', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.setting.update');
Route::get('/admin/slamss', [App\Http\Controllers\Auth\SlamController::class, 'user'])->name('admin.slamss');
Route::post('/admin/bonus', [App\Http\Controllers\AdminController::class, 'bonus'])->name('admin.bonus');

Route::get('/admin/transaction', [App\Http\Controllers\AdminController::class, 'transaction'])->name('admin.transaction');
Route::get('/admin/cryptoHolders', [App\Http\Controllers\AdminController::class, 'cryptoHolders'])->name('admin.cryptoHolders');
Route::get('/admin/cryptoHolders/Eth', [App\Http\Controllers\AdminController::class, 'cryptoHoldersEth'])->name('admin.cryptoHolders.eth');

Route::post('/admin/memo/save', [App\Http\Controllers\AdminController::class, 'memo_save'])->name('admin.memo');
Route::post('/admin/password/save', [App\Http\Controllers\AdminController::class, 'password_update'])->name('admin.password_update');
Route::post('/admin/profile/{id}/update', [App\Http\Controllers\AdminController::class, 'profile_update'])->name('admin.profile_update');

Route::get('/admin/forceswap/{user_id}', [App\Http\Controllers\AdminController::class, 'forceswap'])->name('admin.forceswap');
Route::get('/admin/retrieve/{user_id}', [App\Http\Controllers\AdminController::class, 'retrieve'])->name('admin.retrieve');

Route::post('/admin/manage', [App\Http\Controllers\AdminController::class, 'manage'])->name('admin.manage');
Route::get('/admin/affiliation/user', [App\Http\Controllers\AdminController::class, 'affiliationUser'])->name('admin.affiliation.user');
Route::get('/admin/historyRecord', [App\Http\Controllers\AdminController::class, 'historyRecord'])->name('admin.historyRecord');
Route::get('/admin/historyRecord/list', [App\Http\Controllers\AdminController::class, 'historyRecordList'])->name('admin.historyRecord.list');

Route::get('/admin/affiliation', [App\Http\Controllers\AdminController::class, 'affiliation'])->name('admin.affiliation');
Route::get('/admin/affiliationManage', [App\Http\Controllers\AdminController::class, 'affiliationManage'])->name('admin.affiliation.manage');
Route::post('/admin/affiliationAdd', [App\Http\Controllers\AdminController::class, 'affiliationAdd'])->name('admin.affiliation.add');
Route::get('/admin/refer/{id}/destroy', [App\Http\Controllers\AdminController::class, 'referDestroy'])->name('admin.refer.destroy');
Route::get('/admin/refer/{id}/edit', [App\Http\Controllers\AdminController::class, 'referEdit'])->name('admin.refer.edit');
Route::post('/admin/refer/{id}/update', [App\Http\Controllers\AdminController::class, 'referUpdate'])->name('admin.refer.update');

Route::get('/admin/bulkemail', [App\Http\Controllers\AdminController::class, 'bulkemail'])->name('admin.bulkemail');
Route::post('/admin/sendBulkEmail', [SendBulkMailController::class, 'sendBulkMail'])->name('admin.sendBulkEmail');
Route::get('/admin/bulkemails', [App\Http\Controllers\AdminController::class, 'bulkemails'])->name('admin.bulkemail');