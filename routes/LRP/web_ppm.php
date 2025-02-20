<?php

use App\Http\Controllers\LRP\ControllerPlanningPPMeeting;
use App\Http\Controllers\LRP\ControllerTrace;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'],'/planning_ppm_calendar',[ControllerPlanningPPMeeting::class,'getPlanning'])->name('PLANNING.PPM.calendar');
Route::get('/api/meetings', [ControllerPlanningPPMeeting::class, 'getMeetings']);
Route::get('/api/getNbPPM', [ControllerPlanningPPMeeting::class, 'getNbPPM']);
Route::get('/api/meeting/{eventIdDemande}', [ControllerPlanningPPMeeting::class, 'getMeetingById']);
Route::post('/meeting-update/{id}', [ControllerPlanningPPMeeting::class, 'updateStatus'])->name('PLANNING.PPM.update');
Route::get('/api/chaines', [ControllerPlanningPPMeeting::class, 'getAllChaines']);
Route::get('/api/getStatWeekPPM', [ControllerPlanningPPMeeting::class, 'getStatWeekPPM']);

Route::get('/api/trace', [ControllerTrace::class, 'getTraces']);
Route::get('/api/trace/{eventIdDemande}', [ControllerTrace::class, 'getTraceById']);
Route::post('/trace-update/{id}', [ControllerTrace::class, 'updateStatusTrace'])->name('PLANNING.trace.update');
Route::get('/api/getStatTrace', [ControllerTrace::class, 'getStatTrace']);
Route::get('/api/getStatWeekTrace', [ControllerTrace::class, 'getStatWeekTrace']);

