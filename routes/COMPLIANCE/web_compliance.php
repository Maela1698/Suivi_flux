<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerAuditInterne;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use Illuminate\Support\Facades\Route;

Route::get('/planActionPdf', [ControllerCompliance::class, 'planActionApercu'])->name('COMPLIANCE.planActionPdf');
Route::match(['get', 'post'],'/COMPLIANCE.newAjoutConstat',[ControllerCompliance::class,'newAjoutConstat'])->name('COMPLIANCE.newAjoutConstat');
Route::get('/getConstatDetail', [ControllerCompliance::class, 'getConstatDetail']);
Route::get('/getSections', [ControllerCompliance::class, 'getSections']);
Route::get('/getResponsableSection', [ControllerCompliance::class, 'getResponsableSection']);
Route::get('/addSection', [ControllerCompliance::class, 'addSection'])->name('COMPLIANCE.addSection');


// ROUTE AUDIT INTERNE
Route::match(['get','post'],'/readAuditInterne', [ControllerAuditInterne::class, 'readAudit'])->name('COMPLIANCE.readAuditInterne');
Route::get('/getSectionCompliance', [ControllerAuditInterne::class, 'getSectionCompliance']);
Route::get('/getAuditInterneDetail', [ControllerAuditInterne::class, 'getAuditInterneDetail']);
Route::post('/createAuditInterne', [ControllerAuditInterne::class, 'createAuditInterne'])->name('AUDITINTERNE.Create');
Route::post('/updateAvancement', [ControllerAuditInterne::class, 'updateAvancement'])->name('AUDITINTERNE.Update');
Route::get('/getRapport', [ControllerAuditInterne::class, 'getRapport'])->name('AUDITINTERNE.Rapport');



