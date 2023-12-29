<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\TaskController;
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

Route::view('/', 'welcome');

Route::get('/home', [Authcontroller::class, 'register'])->middleware(['auth'])->name('home');
Route::get('/admin/userlist', [AdminController::class, 'index'])->name('admin.userlist');

Route::get('/task/index', [TaskController::class, 'index'])->middleware('auth')->name('task.index');
Route::get('/task/create', [TaskController::class, 'create'])->middleware('auth')->name('task.create');
Route::post('/task/store', [TaskController::class, 'store'])->middleware('auth')->name('task.store');
Route::post('/update-status', [TaskController::class, 'updateStatus'])->middleware('auth')->name('update.status');
Route::get('/task/edit/{task}', [TaskController::class, 'Edit'])->middleware('auth')->name('task.edit');
Route::put('task/update/{task}', [TaskController::class, 'update'])->middleware('auth')->name('task.update');
Route::delete('/tasks/{task}', [TaskController::class, 'delete'])->middleware('auth')->name('task.destroy');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
