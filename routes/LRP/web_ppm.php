<?php

use App\Http\Controllers\LRP\ControllerPlanningPPMeeting;
use Illuminate\Support\Facades\Route;

Route::get('/planning_ppm_calendar',[ControllerPlanningPPMeeting::class,'getPlanning'])->name('PLANNING.PPM.calendar');
Route::get('/api/meetings', [ControllerPlanningPPMeeting::class, 'getMeetings']);