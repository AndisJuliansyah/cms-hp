<x-filament::card>
    <h2 class="text-lg font-bold mb-4">Ringkasan Nilai</h2>

    @if ($record->is_complete)
        <ul class="space-y-2">
            @foreach ($record->score_summary as $key => $value)
                <li class="flex justify-between">
                    <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                    <span>{{ $value }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Data nilai belum lengkap.</p>
    @endif
</x-filament::card>
