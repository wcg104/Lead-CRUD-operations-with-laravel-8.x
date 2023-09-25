<?php
use Wcg104\Lead\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Wcg104\Lead\Http\Controllers\LeadController;


// Route::prefix('lead')->group(function () {
//     Route::controller(LeadController::class)->group(function () {
//         Route::get('/', 'index');
//         Route::post('/', 'store');
//     });
// });  

Route::apiResource('lead', LeadController::class);