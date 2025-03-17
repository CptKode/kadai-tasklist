<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
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

Route::get('/', [TasksController::class, 'dashboard']);
// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('tasks/create', [TasksController::class, 'create'])->name('tasks.create');
Route::post('tasks', [TasksController::class, 'store'])->name('tasks.store');
Route::resource('tasks', TasksController::class);

Route::middleware('auth')->group(function () {
    Route::resource('tasks', TasksController::class, ['only' => ['index', 'show']]);
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
