<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\organizadorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
}); 

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('/dashboard', [dashboard::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/welcome', [dashboard::class, 'welcome'])->name('welcome');
Route::get('/cargarEventos/{sedeId}', [dashboard::class, 'welcome2']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//filtro de eventos en crud eventos
Route::get('/foros-dependencia/{sede}', [ForoController::class, 'obtenerForosPorDependencia']);

//rutas para crud de eventos
Route::get('/',[CalendarController::class,'index'])->name('index');

Route::middleware('auth', 'role:Admin')->group(function () {
    
    //eventos
    Route::post('welcome/store',[CalendarController::class,'store'])->name('welcome.store');
    Route::patch('welcome/update/{id}',[CalendarController::class,'update'])->name('calendario.update');
    Route::delete('welcome/destroy/{id}',[CalendarController::class,'destroy'])->name('welcome.destroy');
    //RUTAs dasboard.foros
    Route::post('dashboard/foro/store',[ForoController::class,'store'])->name('foro.store');
    Route::patch('dashboard/foro/update',[ForoController::class,'update'])->name('foro.update');
    Route::delete('dashboard/foro/delete/{id}',[ForoController::class,'destroy'])->name('foro.destroy');
    //RUTAs dasboard.organizadores
    
    Route::post('dashboard/organizador/store',[organizadorController::class,'store'])->name('organizador.store');
    Route::patch('dashboard/organizador/update',[organizadorController::class,'update'])->name('organizador.update');
    Route::delete('dashboard/organizador/{id}',[organizadorController::class,'destroy'])->name('organizador.destroy');
    //RUTAs dasboard.usuarios
    
    Route::post('dashboard/usuario/store',[UserController::class,'store'])->name('usuario.store');
    Route::put('dashboard/usuario/update', [UserController::class, 'update'])->name('usuario.update');
    Route::delete('dashboard/usuario/{id}',[UserController::class,'destroy'])->name('usuario.destroy');
    Route::get('dashboard/usuario/ver/{id}', [UserController::class, 'ver'])->name('usuario.ver');
 
});
