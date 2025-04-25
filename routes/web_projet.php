<?php

use App\Http\Controllers\PROJET\ControllerProjet;
use Illuminate\Support\Facades\Route;

Route::get('/portefeuille', [ControllerProjet::class, 'readPortefeuille'])->name('PROJET.readPortefeuille');