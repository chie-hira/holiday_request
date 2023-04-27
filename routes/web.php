<?php

use App\Http\Controllers\RemainingController;
use App\Http\Controllers\ReportController;
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
Route::get('/', function () {
    return view('menu.index');
})->name('menu');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

# reportルーティング
Route::resource('reports', ReportController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('reports', ReportController::class)->only(['index', 'show']);

# remainingルーティング
Route::resource('remainings', RemainingController::class);

# 承認ルーティング
Route::get('/approvals/pending', [ReportController::class, 'approvalPending'])
    ->name('approvals.pending')
    ->middleware('auth', 'can:general_and_factory_gl');
Route::get('/approvals/approved', [ReportController::class, 'approved'])
    ->name('approvals.approved')
    ->middleware('auth', 'can:general_and_factory_gl');
Route::get('/approvals/list', [ReportController::class, 'approvalList'])->name(
    'approvals.list'
);
Route::get('/approval/{report}', [ReportController::class, 'approval'])->name(
    'approval'
);

# remaining加算ルーティング
Route::get('/update_remainings', function () {
    return view('remainings.update_form');
})->name('remainings.update_form');
Route::post('/add_remainings', [
    RemainingController::class,
    'addRemainings',
])->name('remainings.add_remainings');

# 承認後のreport削除
Route::delete('/reports/approved/{report}', [
    ReportController::class,
    'approvedDelete',
])->name('reports.approved_delete');

require __DIR__ . '/auth.php';
