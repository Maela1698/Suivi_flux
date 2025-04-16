<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerAuditInterne;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use Illuminate\Support\Facades\Route;

Route::get('/planActionPdf', [ControllerCompliance::class, 'planActionApercu'])->name('COMPLIANCE.planActionPdf')->middleware('checkrole:Compliance!CRM');
Route::match(['get', 'post'],'/COMPLIANCE.newAjoutConstat',[ControllerCompliance::class,'newAjoutConstat'])->name('COMPLIANCE.newAjoutConstat')->middleware('checkrole:Compliance!CRM');
Route::get('/getConstatDetail', [ControllerCompliance::class, 'getConstatDetail'])->middleware('checkrole:Compliance!CRM');
Route::get('/getSections', [ControllerCompliance::class, 'getSections'])->middleware('checkrole:Compliance!CRM');
Route::get('/getResponsableSection', [ControllerCompliance::class, 'getResponsableSection'])->middleware('checkrole:Compliance!CRM');
Route::get('/addSection', [ControllerCompliance::class, 'addSection'])->name('COMPLIANCE.addSection')->middleware('checkrole:Compliance!CRM');


// ROUTE AUDIT INTERNE
Route::match(['get','post'],'/readAuditInterne', [ControllerAuditInterne::class, 'readAudit'])->name('COMPLIANCE.readAuditInterne')->middleware('checkrole:Compliance!CRM');
Route::get('/getSectionCompliance', [ControllerAuditInterne::class, 'getSectionCompliance'])->middleware('checkrole:Compliance!CRM');
Route::get('/getAuditInterneDetail', [ControllerAuditInterne::class, 'getAuditInterneDetail'])->middleware('checkrole:Compliance!CRM');
Route::post('/createAuditInterne', [ControllerAuditInterne::class, 'createAuditInterne'])->name('AUDITINTERNE.Create')->middleware('checkrole:Compliance!CRM');
Route::post('/updateAvancement', [ControllerAuditInterne::class, 'updateAvancement'])->name('AUDITINTERNE.Update')->middleware('checkrole:Compliance!CRM');
Route::get('/getRapport', [ControllerAuditInterne::class, 'getRapport'])->name('AUDITINTERNE.Rapport')->middleware('checkrole:Compliance!CRM');
Route::get('/ajoutMultiple', [ControllerAuditInterne::class, 'ajoutMultiple'])->name('AUDITINTERNE.ajoutMultiple')->middleware('checkrole:Compliance!CRM');
Route::post('/doAjoutMultiple', [ControllerAuditInterne::class, 'doAjoutMultiple'])->name('AUDITINTERNE.doAjoutMultiple')->middleware('checkrole:Compliance!CRM');
