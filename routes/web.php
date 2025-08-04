<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\UlanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// --- RUTE UNTUK FITUR BELAJAR ---
Route::get('/belajar', [BelajarController::class, 'index'])->name('belajar.index');
Route::get('/belajar/{alphabet}', [BelajarController::class, 'show'])->name('belajar.show');

// --- RUTE UNTUK FITUR LATIHAN ---
Route::get('/latihan', [LatihanController::class, 'index'])->name('latihan.index');
Route::get('/latihan/{level}', [LatihanController::class, 'show'])->name('latihan.show');
Route::post('/latihan/selesai', [LatihanController::class, 'storeResult'])->name('latihan.storeResult');
Route::get('/latihan/hasil/{result}', [LatihanController::class, 'showResult'])->name('latihan.showResult');

// --- RUTE UNTUK FITUR ULANGAN ---
Route::prefix('ulangan')->name('ulangan.')->group(function () {
    Route::get('/', [UlanganController::class, 'index'])->name('index');
    Route::get('/{exam}/cek-wajah', [UlanganController::class, 'showFaceCheck'])->name('face-check');
    Route::post('/{exam}/simpan-foto', [UlanganController::class, 'storeFaceImage'])->name('store-face-image');
    Route::get('/{exam_result}/soal', [UlanganController::class, 'showSoal'])->name('soal');
    Route::post('/selesai', [UlanganController::class, 'storeResult'])->name('storeResult');
    Route::get('/hasil/{exam_result}', [UlanganController::class, 'showResult'])->name('showResult');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/ulangan-baru', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/ulangan-baru', [ExamController::class, 'store'])->name('exams.store');
    Route::delete('/exams/{exam}', [DashboardController::class, 'destroyExam'])->name('exams.destroy');
    Route::delete('/hasil-ulangan/{result}', [DashboardController::class, 'destroyResult'])->name('exam-results.destroy');
    Route::get('/export/hasil-ulangan/pdf', [DashboardController::class, 'exportResultsPdf'])->name('exam-results.export-pdf');
    Route::get('/hasil-ulangan/{result}/detail', [DashboardController::class, 'showResultDetail'])->name('exam-results.detail');
});

require __DIR__ . '/auth.php';
