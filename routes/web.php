<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\PatientHistoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes that can be accessed without authentication
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // landing + dashboard
Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
Route::get('/queues/{queue}', [QueueController::class, 'show'])->name('queues.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // My Patients
    Route::get('/my-patients', [PatientController::class, 'index'])->name('patients.index');

    // Create patient with queue
    Route::get('/patients/create-with-queue', [PatientController::class, 'createWithQueue'])->name('patients.createWithQueue');
    Route::post('/patients', [PatientController::class, 'storeWithQueue'])->name('patients.storeWithQueue');

    // Edit, update, delete patients (UUID)
    Route::get('/patients/{id_pasien}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{id_pasien}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id_pasien}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // suggestions
    Route::get('/suggestions/create', [SuggestionController::class, 'create'])->name('suggestions.create'); // form tambah saran
    Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store'); // simpan saran
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('admin.dashboard');

    Route::post('/queues/{id_antrian}', [AdminController::class, 'callAdmin'])->name('admin.call');


    // Users management
    Route::get('/users', [UserController::class, 'indexAdmin'])->name('admin.users.indexAdmin');
    Route::get('/users/{id_pengguna}/edit', [UserController::class, 'editAdmin'])->name('admin.users.editAdmin');
    Route::put('/users/{id_pengguna}', [UserController::class, 'updateAdmin'])->name('admin.users.updateAdmin');
    Route::delete('/users/{id_pengguna}', [UserController::class, 'destroyAdmin'])->name('admin.users.destroyAdmin');

    // Patients management (admin)
    Route::get('/patients', [PatientController::class, 'indexAdmin'])->name('admin.patients.indexAdmin');
    Route::get('/patients/{id_pasien}/edit', [PatientController::class, 'editAdmin'])->name('admin.patients.editAdmin');
    Route::put('/patients/{id_pasien}', [PatientController::class, 'updateAdmin'])->name('admin.patients.updateAdmin');
    Route::delete('/patients/{id_pasien}', [PatientController::class, 'destroyAdmin'])->name('admin.patients.destroyAdmin');
    
    // Information management
    Route::get('/informations', [InformationController::class, 'indexAdmin'])->name('admin.informations.indexAdmin');
    Route::get('/informations/create', [InformationController::class, 'createAdmin'])->name('admin.informations.createAdmin');
    Route::post('/informations', [InformationController::class, 'storeAdmin'])->name('admin.informations.storeAdmin');
    Route::get('/informations/{id_informasi}/edit', [InformationController::class, 'editAdmin'])->name('admin.informations.editAdmin');
    Route::put('/informations/{id_informasi}', [InformationController::class, 'updateAdmin'])->name('admin.informations.updateAdmin');
    Route::delete('/informations/{id_informasi}', [InformationController::class, 'destroyAdmin'])->name('admin.informations.destroyAdmin');


    // Suggestions management
    Route::get('/suggestions', [SuggestionController::class, 'indexAdmin'])->name('admin.suggestions.indexAdmin');
    Route::get('/suggestions/{id_saran}/edit', [SuggestionController::class, 'editAdmin'])->name('admin.suggestions.editAdmin');
    Route::put('/suggestions/{id_saran}', [SuggestionController::class, 'updateAdmin'])->name('admin.suggestions.updateAdmin');
    Route::delete('/suggestions/{id_saran}', [SuggestionController::class, 'destroyAdmin'])->name('admin.suggestions.destroyAdmin');

    // Queues management
    Route::get('/queues', [QueueController::class, 'indexAdmin'])->name('admin.queues.indexAdmin');
    Route::get('/queues/{id_antrian}/edit', [QueueController::class, 'editAdmin'])->name('admin.queues.editAdmin');
    Route::put('/queues/{id_antrian}', [QueueController::class, 'updateAdmin'])->name('admin.queues.updateAdmin');
    Route::delete('/queues/{id_antrian}', [QueueController::class, 'destroyAdmin'])->name('admin.queues.destroyAdmin');
    
    // Call pasien (pindah ke history)
    Route::post('/queues/{id_antrian}/call', [QueueController::class, 'callAdmin'])->name('admin.queues.callAdmin');
    Route::get('patientsHistory/index', [PatientHistoryController::class, 'indexAdmin'])->name('admin.patientsHistory.indexAdmin');
    Route::get('patientsHistory/{id_history}/edit', [PatientHistoryController::class, 'editAdmin'])->name('admin.patientsHistory.editAdmin');
    Route::put('patientsHistory/{id_history}', [PatientHistoryController::class, 'updateAdmin'])->name('admin.patientsHistory.updateAdmin');
    Route::delete('patientsHistory/{id_history}', [PatientHistoryController::class, 'destroyAdmin'])->name('admin.patientsHistory.destroyAdmin');
});
