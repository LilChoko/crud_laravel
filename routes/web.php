<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Proteger las rutas de tareas con el middleware personalizado
Route::middleware(\App\Http\Middleware\AuthenticateCustom::class)->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('home');
    Route::resource('tasks', TaskController::class);
});

Route::post('/logout', function () {
    Auth::logout();  // Cierra la sesión del usuario
    return redirect('/login');  // Redirige a la página de login
})->name('logout');

Route::get('/admin/settings', function () {
    return view('adminlte.alta'); // Cambia 'adminlte.alta' por la ruta a tu vista
})->name('admin.settings');

Route::post('/admin/settings', [AlumnoController::class, 'store'])->name('alumnos.store');
