<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerAuditInterne;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use Illuminate\Support\Facades\Route;

Route::get('/planActionPdf', [ControllerCompliance::class, 'planActionApercu'])->name('COMPLIANCE.planActionPdf')->middleware('checkrole:Compliance');
Route::match(['get', 'post'],'/COMPLIANCE.newAjoutConstat',[ControllerCompliance::class,'newAjoutConstat'])->name('COMPLIANCE.newAjoutConstat')->middleware('checkrole:Compliance');
Route::get('/getConstatDetail', [ControllerCompliance::class, 'getConstatDetail'])->middleware('checkrole:Compliance');
Route::get('/getSections', [ControllerCompliance::class, 'getSections'])->middleware('checkrole:Compliance');
Route::get('/getResponsableSection', [ControllerCompliance::class, 'getResponsableSection'])->middleware('checkrole:Compliance');
Route::get('/addSection', [ControllerCompliance::class, 'addSection'])->name('COMPLIANCE.addSection')->middleware('checkrole:Compliance');


// ROUTE AUDIT INTERNE
Route::match(['get','post'],'/readAuditInterne', [ControllerAuditInterne::class, 'readAudit'])->name('COMPLIANCE.readAuditInterne')->middleware('checkrole:Compliance');
Route::get('/getSectionCompliance', [ControllerAuditInterne::class, 'getSectionCompliance'])->middleware('checkrole:Compliance');
Route::get('/getAuditInterneDetail', [ControllerAuditInterne::class, 'getAuditInterneDetail'])->middleware('checkrole:Compliance');
Route::post('/createAuditInterne', [ControllerAuditInterne::class, 'createAuditInterne'])->name('AUDITINTERNE.Create')->middleware('checkrole:Compliance');
Route::post('/updateAvancement', [ControllerAuditInterne::class, 'updateAvancement'])->name('AUDITINTERNE.Update')->middleware('checkrole:Compliance');
Route::get('/getRapport', [ControllerAuditInterne::class, 'getRapport'])->name('AUDITINTERNE.Rapport')->middleware('checkrole:Compliance');



