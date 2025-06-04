<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hpq;

Route::redirect('/', '/admin');

Route::get('/admin/hpq/{hpq}/summary', function (Hpq $hpq) {
    $hpq->load('scores');

    return view('filament.hpq-score-summary', [
        'hpq' => $hpq,
        'summary' => $hpq->score_summary,
    ]);
})->name('filament.hpq.custom-view');
