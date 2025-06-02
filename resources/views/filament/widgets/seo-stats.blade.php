<x-filament::widget>
    <x-filament::card class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">📈 Statistik SEO</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl shadow-sm">
                <div class="text-sm text-blue-800">Total Artikel</div>
                <div class="text-3xl font-bold text-blue-900">{{ $totalArticles }}</div>
            </div>

            <div class="bg-green-50 border border-green-200 p-4 rounded-2xl shadow-sm">
                <div class="text-sm text-green-800">Artikel SEO Lengkap</div>
                <div class="text-3xl font-bold text-green-900">{{ $seoComplete }}</div>
            </div>

            <div class="bg-red-50 border border-red-200 p-4 rounded-2xl shadow-sm">
                <div class="text-sm text-red-800">Artikel Belum SEO</div>
                <div class="text-3xl font-bold text-red-900">{{ $seoIncomplete }}</div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-2xl shadow-sm">
                <div class="text-sm text-yellow-800">Persentase SEO</div>
                <div class="text-3xl font-bold text-yellow-900">{{ $percentage }}%</div>
            </div>
        </div>

        {{-- Stylish Progress Bar --}}
        <div class="space-y-1">
            <div class="text-sm font-medium text-gray-600">Progress SEO Keseluruhan</div>
            <div class="w-full bg-gray-200 rounded-full h-5 shadow-inner">
                <div
                    class="h-5 rounded-full transition-all duration-500 flex items-center justify-center text-xs font-semibold text-white"
                    style="width: {{ $percentage }}%; background-color:
                        {{ $percentage >= 75 ? '#22c55e' : ($percentage >= 50 ? '#eab308' : '#ef4444') }};">
                    {{ $percentage }}%
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
