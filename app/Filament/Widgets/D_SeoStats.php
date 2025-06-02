<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Article;

class D_SeoStats extends Widget
{
    protected static string $view = 'filament.widgets.seo-stats';

    protected function getViewData(): array
    {
        $totalArticles = Article::count();
        $seoComplete = Article::whereNotNull('seo_title')->whereNotNull('seo_description')->count();
        $seoIncomplete = $totalArticles - $seoComplete;

        $percentage = $totalArticles > 0 ? round(($seoComplete / $totalArticles) * 100) : 0;

        return compact('totalArticles', 'seoComplete', 'seoIncomplete', 'percentage');
    }

    public static function canView(): bool
    {
        return true;
    }

    public function getColumns(): int
    {
        return 1;
    }
}
