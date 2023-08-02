<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\RemainingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Models\ReportCategory;
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

// TODO:policy,can設定、自分しか自分の投稿を編集、削除申請できない
# reportルーティング
Route::resource('reports', ReportController::class)
    ->only(['create', 'show'])
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

# my_indexルーティング
Route::get('/my_reports', [ReportController::class, 'myIndex'])
    ->name('reports.my_index')
    ->middleware('auth');

# remainingルーティング
Route::resource('remainings', RemainingController::class)->middleware('auth');

# usersルーティング
Route::resource('users', UserController::class)->middleware('auth');

# approvalsルーティング
Route::resource('approvals', ApprovalController::class)->middleware('auth');

# 承認ルーティング
// Route::get('/pending_approval', [ReportController::class, 'pendingApproval'])
//     ->name('reports.pending_approval')
//     ->middleware('auth', 'can:general_gl_reader');
// Route::get('/approved', [ReportController::class, 'approved'])
//     ->name('reports.approved')
//     ->middleware('auth', 'can:general_gl_reader');
Route::get('/get_and_remaining', [ReportController::class, 'getAndRemaining'])
    ->name('reports.get_and_remaining')
    ->middleware('auth', 'can:general_gl_reader');
Route::get('/approval/{report}', [ReportController::class, 'approval'])
    ->name('approval')
    ->middleware('auth');
Route::get('/approval/{report}/cancel', [
    ReportController::class,
    'approvalCancel',
])
    ->name('reports.approval_cancel')
    ->middleware('auth');

# remaining加算ルーティング
Route::get('/update_remainings', function () {
    return view('remainings.update_form');
})
    ->name('remainings.update_form')
    ->middleware('auth');
Route::post('/add_remainings', [RemainingController::class, 'addRemainings'])
    ->name('remainings.add_remainings')
    ->middleware('auth');

# my_indexルーティング
Route::get('/my_remainings', [RemainingController::class, 'myIndex'])
    ->name('remainings.my_index')
    ->middleware('auth');

# menuルーティング
Route::get('/', [ReportController::class, 'menu'])
    ->name('menu')
    ->middleware('auth');

# 承認後のreport削除
Route::delete('/reports/approved/{report}/cancel', [
    ReportController::class,
    'approvedCancel',
])
    ->name('reports.approved_cancel')
    ->middleware('auth');

# エクスポート
Route::get('/export_form', [ReportController::class, 'export_form'])
    ->name('reports.export_form')
    ->middleware('auth');
Route::post('/export', [ReportController::class, 'export'])
    ->name('reports.export')
    ->middleware('auth');
// Route::get('/export', [ReportController::class, 'export'])
//     ->name('reports.export')
//     ->middleware('auth');

require __DIR__ . '/auth.php';
