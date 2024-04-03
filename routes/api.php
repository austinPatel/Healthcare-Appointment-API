<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\SignInController;
use App\Http\Controllers\Api\SignUpController;
use App\Http\Controllers\Api\HealthcareProfessionalController;
use App\Http\Controllers\Api\AppointmentController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/sign-in', [SignInController::class, 'login']);
Route::post('user/sign-up', [SignUpController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('get-healthcare-professional',[HealthcareProfessionalController::class,'index']);
    // Route::post('book-appointment',[AppointmentController::class,'store']);
});
Route::group(
    [
        'prefix' => 'user',
        'as' => 'appointment.',
        'middleware' => ['auth:api']
    ],
    function () {
        Route::get('appointment/', [AppointmentController::class, 'index'])->name('index');
        Route::post('appointment/booked', [AppointmentController::class, 'store'])->name('store');
        Route::get('appointment/view', [AppointmentController::class, 'show'])->name('show'); 
        Route::patch('appointment/cancelled', [AppointmentController::class, 'cancelled'])->name('cancelled');
        Route::patch('appointment/complete', [AppointmentController::class, 'complete'])->name('complete');

    }
    // we can also made the appointment resources e.g appointment -(GET(All appointment)/POST(Booked)/Patch(cancelled)/PUT(completed))
);