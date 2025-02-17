<?php

use App\Http\Controllers\LRP\ControllerPlanningPPMeeting;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'],'/planning_ppm_calendar',[ControllerPlanningPPMeeting::class,'getPlanning'])->name('PLANNING.PPM.calendar');
Route::get('/api/meetings', [ControllerPlanningPPMeeting::class, 'getMeetings']);
Route::get('/api/getNbPPM', [ControllerPlanningPPMeeting::class, 'getNbPPM']);
Route::get('/api/meeting/{eventIdDemande}', [ControllerPlanningPPMeeting::class, 'getMeetingById']);
Route::post('/meeting-update/{id}', [ControllerPlanningPPMeeting::class, 'updateStatus'])->name('PLANNING.PPM.update');

Route::get('/api/trace', [ControllerPlanningPPMeeting::class, 'getTraces']);
Route::get('/api/trace/{eventIdDemande}', [ControllerPlanningPPMeeting::class, 'getTraceById']);
Route::post('/trace-update/{id}', [ControllerPlanningPPMeeting::class, 'updateStatusTrace'])->name('PLANNING.trace.update');




