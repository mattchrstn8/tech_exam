<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->get();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks
        ]);
    })->name('dashboard');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/task/create', [TaskController::class, 'create'])->name('tasks.create');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/task/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/task', [TaskController::class, 'index'])->name('tasks');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/task', [TaskController::class, 'store'])->name('tasks.store');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->put('/task/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/task/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

