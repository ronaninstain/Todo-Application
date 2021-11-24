<?php

use App\Http\Controllers\TasksController;
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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', [TasksController::class, 'index'])->name('dashboard');

    Route::get('/task',[TasksController::class, 'add']);
    Route::post('/task',[TasksController::class, 'create']);

    Route::get('/task/{task}', [TasksController::class, 'edit']);
    Route::post('/task/{task}', [TasksController::class, 'update']);

    Route::get('/task-all',[TasksController::class, 'index_all']);
    Route::get('/task-complete',[TasksController::class, 'index_complete']);
    Route::get('/task-incomplete',[TasksController::class, 'index_incomplete']);

});

require __DIR__.'/auth.php';
