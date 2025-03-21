<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use Illuminate\Support\Facades\Route;

Route::get('/planActionPdf', [ControllerCompliance::class, 'planActionApercu'])->name('COMPLIANCE.planActionPdf');
Route::match(['get', 'post'],'/COMPLIANCE.newAjoutConstat',[ControllerCompliance::class,'newAjoutConstat'])->name('COMPLIANCE.newAjoutConstat');
Route::get('/getConstatDetail', [ControllerCompliance::class, 'getConstatDetail']);
Route::get('/getSections', [ControllerCompliance::class, 'getSections']);
Route::get('/getResponsableSection', [ControllerCompliance::class, 'getResponsableSection']);
Route::get('/addSection', [ControllerCompliance::class, 'addSection'])->name('COMPLIANCE.addSection');
Route::get('/updateAvancement', [ControllerCompliance::class, 'updateAvancement'])->name('COMPLIANCE.updateAvancement');
