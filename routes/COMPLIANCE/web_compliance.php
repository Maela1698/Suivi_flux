<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use Illuminate\Support\Facades\Route;

Route::get('/planActionPdf', [ControllerCompliance::class, 'planActionApercu'])->name('COMPLIANCE.planActionPdf');
