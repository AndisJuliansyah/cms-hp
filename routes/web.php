<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hpq;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/hpq/{hpq}/summary', function (Hpq $hpq) {
    // Pastikan eager load score_summary kalau perlu
    $hpq->load('scores'); // jika relasi diperlukan

    return view('filament.hpq-score-summary', [
        'hpq' => $hpq,
        'summary' => $hpq->score_summary, // asumsi accessor score_summary sudah ada
    ]);
})->name('filament.hpq.custom-view');
