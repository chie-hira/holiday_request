<?php

use App\Http\Controllers\AcquisitionDayController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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
    // ->middleware('block.datetime')
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only('show')
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only('store')
    ->middleware('throttle:5, 1') # 1分間に受け付けるリクエスト数を5回に制限
    ->middleware('auth');
// ReportControllerTestを実行するときはリクエスト制限を外すこと
Route::resource('reports', ReportController::class)
    ->only(['edit', 'update'])
    ->middleware('can:update,report')
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only('destroy')
    ->middleware('can:delete,report')
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only('index')
    ->middleware('can:approver_reader')
    ->middleware('auth');
Route::get('/my_reports', [ReportController::class, 'myIndex'])
    ->name('reports.my_index')
    ->middleware('auth');

# acquisition_daysルーティング
Route::resource('acquisition_days', AcquisitionDayController::class)
    ->middleware('can:admin')
    ->middleware('auth');
Route::get('/my_acquisition_days', [AcquisitionDayController::class, 'myIndex'])
    ->name('acquisition_days.my_index')
    ->middleware('auth');
Route::get('/acquisition_status', [
    AcquisitionDayController::class,
    'acquisitionStatus',
])
    ->name('acquisition_days.status_index')
    ->middleware('can:approver_reader')
    ->middleware('auth');
Route::get('/update_form', [AcquisitionDayController::class, 'updateForm'])
    ->name('acquisition_days.update_form')
    ->middleware('can:general_admin')
    ->middleware('auth');
// Route::get('/update_form', function () {
//     return view('acquisition_days.update_form');
// })
//     ->name('acquisition_days.update_form')
//     ->middleware('can:general_admin')
//     ->middleware('auth');
Route::post('/add_remainings', [
    AcquisitionDayController::class,
    'addRemainings',
])
    ->name('acquisitions_days.add_remainings')
    ->middleware('can:general_admin')
    ->middleware('auth');

# usersルーティング
Route::resource('users', UserController::class)
    ->middleware('can:admin')
    ->middleware('auth');

# approvalsルーティング
Route::resource('approvals', ApprovalController::class)
    ->middleware('can:admin')
    ->middleware('auth');

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
# explanationsルーティング
Route::get('/explanations', function () {
    return view('explanations.index');
})
    ->name('explanations')
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
    ->middleware('can:approver_reader')
    ->middleware('auth');
Route::get('/export', [ReportController::class, 'export'])
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
Route::post('/reports_import', [ReportController::class, 'import'])->name(
    'reports_import'
);
Route::post('/acquisition_days_import', [
    AcquisitionDayController::class,
    'import',
])->name('acquisition_days_import');
Route::get('/initial_import', [
    AcquisitionDayController::class,
    'initial_import',
])->name('initial_import');

# 検索
Route::get('/search', [ReportController::class, 'search'])
    ->name('search')
    ->middleware('auth');
Route::get('/export_search', [ReportController::class, 'export_search'])
    ->name('export_search')
    ->middleware('auth');

#profile これは使わない
Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'account'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'mail_address_edit'])->name('profile.mail_address_edit');
    Route::get('/password', [ProfileController::class, 'password_edit'])->name('profile.password_edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.change');
});

#profile_admin
Route::middleware('auth')->group(function () {
    // Route::get('/account', [ProfileController::class, 'account'])->name('profile.edit');
    Route::get('users/{user}/email_edit', [UserController::class, 'email_edit'])->name('users.email_edit');
    Route::get('users/{user}/password_edit', [UserController::class, 'password_edit'])->name('users.password_edit');
    Route::patch('users/email_update/{user}', [UserController::class, 'email_update'])->name('users.email_update');
    Route::put('users/password_update/{user}', [UserController::class, 'password_update'])->name('users.password_update');
});


// TODO:notAuthorizedでログイン画面にリダイレクト

require __DIR__ . '/auth.php';
