<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
Route::get('/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
Route::patch('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
Route::resource('events', EventController::class)->middleware(['auth']);
Route::post('events/{event}/manage', [EventController::class, 'manage'])->name('events.manage')->middleware(['auth']);

Route::get('/', function () {
    return redirect()->route('events.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
