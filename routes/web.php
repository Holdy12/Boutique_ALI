<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController; // <-- Cet import doit être exact
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/clients');
});
Route::get('/', function () {
    return redirect('/dashboard'); // J'ai modifié la redirection vers le dashboard pour commencer par là !
});

// --- MODULE DASHBOARD ---
Route::get('/dashboard', [DashboardController::class, 'index']); // <--- AJOUTE CETTE LIGNE

// --- MODULE CLIENTS ---
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/create', [ClientController::class, 'create']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}/edit', [ClientController::class, 'edit']);
Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

// --- MODULE PRODUITS ---
Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/create', [ProduitController::class, 'create']);
Route::post('/produits', [ProduitController::class, 'store']);
Route::get('/produits/{id}/edit', [ProduitController::class, 'edit']);
Route::put('/produits/{id}', [ProduitController::class, 'update']);
Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);

// --- MODULE COMMANDES ---
Route::get('/commandes', [CommandeController::class, 'index']);
Route::get('/commandes/create', [CommandeController::class, 'create']);
Route::post('/commandes', [CommandeController::class, 'store']);
Route::get('/commandes/{id}/edit', [CommandeController::class, 'edit']);
Route::put('/commandes/{id}', [CommandeController::class, 'update']);
Route::get('/commandes/{id}/pdf', [CommandeController::class, 'downloadPDF']);
Route::delete('/commandes/{id}', [CommandeController::class, 'destroy']);
