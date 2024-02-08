<?php

use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\MeetingMinuteController;
use App\Http\Controllers\API\PDFGeneratorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EventController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::get('/event', [EventController::class, 'index']);

// Get a specific meeting
Route::get('/upcoming-meetings/{id}', [EventController::class, 'show']);
Route::get('/previous-meetings/{id}', [EventController::class, 'showID']);

// Create a new meeting
Route::post('/event', [EventController::class, 'store']);

// Update a meeting
Route::put('/event/{id}', [EventController::class, 'update']);

// Delete a meeting
Route::delete('/event/{id}', [EventController::class, 'destroy']);

Route::get('/upcoming-meetings', [EventController::class, 'upcomingMeetings']);
Route::get('/previous-meetings', [EventController::class, 'previousMeetings']);


// Annoncement

//announcement
Route::get('/announcement', [AnnouncementController::class, 'index']);

// Get a specific meeting
Route::get('/announcement/{id}', [AnnouncementController::class, 'show']);

// Create a new meeting
Route::post('/announcement', [AnnouncementController::class, 'store']);

// Update a meeting
Route::put('/announcement/{id}', [AnnouncementController::class, 'update']);

// Delete a meeting
Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy']);


Route::post('meetingMinute', [MeetingMinuteController::class, 'storeMeetingMinutes']);

Route::post('save-pdf', [PDFGeneratorController::class, 'generatePdf']);
