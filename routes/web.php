<?php

use App\Http\Controllers\ApprovalCategoryController;
use App\Http\Controllers\RemainingController;
use App\Http\Controllers\ReportController;
use App\Models\Report;
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

Route::get('/', function () {
    return view('menu.index');
})->name('menu');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('reports', ReportController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('reports', ReportController::class)
    ->only(['index', 'show']);
    
Route::resource('remainings', RemainingController::class);

Route::get('/reports/index/all', [ReportController::class, 'all_index'])
    ->name('reports.all_index')
    ->middleware('auth', 'can:general_only');

Route::get('/approvals', [ReportController::class, 'approvalPending'])
    ->name('approvals.index');
// Route::get('/approvals/all', [ReportController::class, 'allApprovalPending'])
//     ->name('approvals.all_index');
Route::get('/approval1/{report}', [ReportController::class, 'approval1'])
    ->name('approval1');
Route::get('/approval2/{report}', [ReportController::class, 'approval2'])
    ->name('approval2');
Route::get('/approval3/{report}', [ReportController::class, 'approval3'])
    ->name('approval3');

require __DIR__.'/auth.php';
