<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ArticleCategory;
use App\Models\Article;

class C_ContentAnalysis extends ChartWidget
{
    protected static ?string $heading = 'Analisis Konten';

    protected function getData(): array
    {
        $categories = ArticleCategory::with('articles')->get();

        $labels = [];
        $articleCounts = [];
        $viewsCounts = [];

        foreach ($categories as $category) {
            $labels[] = $category->name;
            $articleCounts[] = $category->articles->count();       // Jumlah artikel
            $viewsCounts[] = $category->articles->sum('views');    // Total views
        }

        $colors = $this->generateColors(count($labels));

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Artikel',
                    'data' => $articleCounts,
                    'backgroundColor' => $colors,
                ],
                [
                    'label' => 'Total Views',
                    'data' => $viewsCounts,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * Generate distinct color hex codes
     */
    private function generateColors(int $count): array
    {
        $presetColors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#6366F1',
            '#8B5CF6', '#EC4899', '#14B8A6', '#EAB308', '#F97316',
            '#0EA5E9', '#22C55E', '#A855F7', '#F43F5E', '#7C3AED'
        ];

        $colors = [];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = $presetColors[$i % count($presetColors)];
        }

        return $colors;
    }

    public function getColumns(): int
    {
        return 3;
    }
}
