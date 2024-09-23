<?php
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
/*-----Patients Routes------*/
Route::resource('patients', PatientController::class);
Route::get('/patient/{phone}', [AppointmentController::class, 'getPatientByPhone']);


/*-----Doctor Routes------*/
Route::resource('doctors', DoctorController::class);
// AJAX route for fetching doctor details and available time slots
Route::get('/doctor-details/{doctorId}', [AppointmentController::class, 'getDoctorDetails']);


/*-----Appointments Routes------*/
Route::resource('appointments', AppointmentController::class);
// Route to handle status changes for appointments
Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');


/*-----Extras----*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
