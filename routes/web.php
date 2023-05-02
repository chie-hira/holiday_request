<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\RemainingController;
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

# メニュー画面
// Route::get('/', function () {
//     return view('menu.index');
// })->name('menu');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

# reportルーティング
Route::resource('reports', ReportController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only(['index', 'show'])
    ->middleware('auth');

# remainingルーティング
Route::resource('remainings', RemainingController::class);

# usersルーティング
Route::resource('users', UserController::class);

# approvalsルーティング
Route::resource('approvals', ApprovalController::class)->middleware('auth');

# 承諾ルーティング
Route::get('/pending_approval', [ReportController::class, 'pendingApproval'])
    ->name('reports.pending_approval')
    ->middleware('auth', 'can:general_and_factory_gl');
Route::get('/approved', [ReportController::class, 'approved'])
    ->name('reports.approved')
    ->middleware('auth', 'can:general_and_factory_gl');
Route::get('/get_and_remaining', [ReportController::class, 'getAndRemaining'])->name(
    'reports.get_and_remaining'
);
Route::get('/approval/{report}', [ReportController::class, 'approval'])->name(
    'approval'
);
Route::get('/approval/{report}/cancel', [ReportController::class, 'approvalCancel'])->name(
    'reports.approval_cancel'
);

# remaining加算ルーティング
Route::get('/update_remainings', function () {
    return view('remainings.update_form');
})->name('remainings.update_form');
Route::post('/add_remainings', [
    RemainingController::class,
    'addRemainings',
])->name('remainings.add_remainings');

# my_indexルーティング
Route::get('/my_remainings', [RemainingController::class, 'myIndex'])->name(
    'remainings.my_index'
);

# menuルーティング
Route::get('/', [ReportController::class, 'menu'])->name(
    'menu'
);

# 承諾後のreport削除
Route::delete('/reports/approved/{report}/cancel', [
    ReportController::class,
    'approvedCancel',
])->name('reports.approved_cancel');

require __DIR__ . '/auth.php';
