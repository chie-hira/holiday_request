<?php

use App\Http\Controllers\AcquisitionDayController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })
//     ->middleware(['auth'])
//     ->name('dashboard');

# reportルーティング
Route::resource('reports', ReportController::class)
    ->only('create')
    ->middleware('auth')
    ->middleware('block.datetime');
Route::resource('reports', ReportController::class)
    ->only('show')
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only('store')
    ->middleware('auth')
    ->middleware('throttle:5, 1'); # 1分間に受け付けるリクエスト数を5回に制限
// ReportControllerTestを実行するときはリクエスト制限を外すこと
Route::resource('reports', ReportController::class)
    ->only(['edit', 'update'])
    ->middleware('auth')
    ->middleware('can:update,report');
Route::resource('reports', ReportController::class)
    ->only('destroy')
    ->middleware('auth')
    ->middleware('can:delete,report');
Route::resource('reports', ReportController::class)
    ->only('index')
    ->middleware('auth')
    ->middleware('can:approver_reader');
Route::get('/my_reports', [ReportController::class, 'myIndex'])
    ->name('reports.my_index')
    ->middleware('auth');

# acquisition_daysルーティング
Route::resource('acquisition_days', AcquisitionDayController::class)
    ->middleware('auth')
    ->middleware('can:admin');
Route::get('/my_acquisition_days', [AcquisitionDayController::class, 'myIndex'])
    ->name('acquisition_days.my_index')
    ->middleware('auth');
Route::get('/acquisition_status', [
    AcquisitionDayController::class,
    'acquisitionStatus',
])
    ->name('acquisition_days.status_index')
    ->middleware('auth')
    ->middleware('can:approver_reader');
Route::get('/update_form', function () {
    return view('acquisition_days.update_form');
})
    ->name('acquisition_days.update_form')
    ->middleware('auth')
    ->middleware('can:general_admin');
Route::post('/add_remainings', [
    AcquisitionDayController::class,
    'addRemainings',
])
    ->name('acquisitions_days.add_remainings')
    ->middleware('auth')
    ->middleware('can:general_admin');

# usersルーティング
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->middleware('can:admin');

# approvalsルーティング
Route::resource('approvals', ApprovalController::class)
    ->middleware('auth')
    ->middleware('can:admin');

# 承認ルーティング
Route::get('/approval/{report}', [ReportController::class, 'approval'])
    ->name('approval')
    ->middleware('auth');
Route::get('/approval/{report}/cancel', [
    ReportController::class,
    'approvalCancel',
])
    ->name('reports.approval_cancel')
    ->middleware('auth');

# menuルーティング
Route::get('/', [ReportController::class, 'menu'])
    ->name('menu')
    ->middleware('auth');
# monitorルーティング
Route::get('/monitor', [ReportController::class, 'monitor'])
    ->name('monitor');

# 承認後のreport削除
Route::put('/reports/approved/{report}/cancel', [
    ReportController::class,
    'approvedCancel',
])
    ->name('reports.approved_cancel')
    ->middleware('auth');

# エクスポート
Route::get('/export_form', [ReportController::class, 'export_form'])
    ->name('reports.export_form')
    ->middleware('auth')
    ->middleware('can:approver_reader');
Route::post('/export', [ReportController::class, 'export'])
    ->name('reports.export')
    ->middleware('auth');
Route::get('/all_export', [ReportController::class, 'all_export'])->middleware(
    'auth'
);

# インポート
Route::get('/import_form', function () {
    return view('menu.import_form');
})->name(
    'import_form'
);
Route::post('/users_import', [UserController::class, 'import'])->name(
    'users_import'
);
Route::post('/approvals_import', [ApprovalController::class, 'import'])->name(
    'approvals_import'
);
Route::post('/acquisition_days_import', [
    AcquisitionDayController::class,
    'import',
])->name('acquisition_days_import');
Route::get('/initial_import', [
    AcquisitionDayController::class,
    'initial_import',
])->name('initial_import');

// TODO:notAuthorizedでログイン画面にリダイレクト

require __DIR__ . '/auth.php';
