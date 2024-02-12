<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LeadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/lead', [LeadController::class, 'store'])->name('leads.store');
Route::patch('/lead/{id}', [LeadController::class, 'update'])->name('leads.update');
Route::get('lead/{id}', [LeadController::class, 'show'])->name('leads.show');
Route::delete('lead/{id}', [LeadController::class, 'destroy'])->name('leads.destroy');
