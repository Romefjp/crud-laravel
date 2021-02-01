<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

//routes for panel
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('clientes', [ClienteController::class, 'index'])->name('clientes');
Route::post('clientes/agregar', [ClienteController::class, 'agregar'])->name('clientes.agregar');
Route::post('clientes/editar', [ClienteController::class, 'editar'])->name('clientes.editar');
Route::get('clientes/eliminar/{cliente}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');
Route::get('clientes/obtener_datos/{cliente}', [ClienteController::class, 'obtener_datos'])->name('clientes.obtener_datos');
