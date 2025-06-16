<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hpq;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/hpq/{hpq}/summary', function (Hpq $hpq) {
    $hpq->load('scores');

    return view('filament.hpq-score-summary', [
        'hpq' => $hpq,
        'summary' => $hpq->score_summary,
    ]);
})->name('filament.hpq.custom-view');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/artikel'))
        ->add(Url::create('/event'))
        ->add(Url::create('/upcoming'))
        ->add(Url::create('/hpq-evaluate'));

    return $sitemap->toResponse(request());
});
