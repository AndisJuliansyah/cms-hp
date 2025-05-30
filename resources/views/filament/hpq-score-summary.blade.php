<x-filament::page>
    <div class="space-y-6">
        <x-filament::section heading="Informasi Umum">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-sm">
                <div class="text-center">
                    <dt class="font-semibold">Kode HPQ</dt>
                    <dd>{{ $record->code_hpq }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Nama</dt>
                    <dd>{{ $record->full_name }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Merk</dt>
                    <dd>{{ $record->brand_name }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Nama Sampel Kopi</dt>
                    <dd>{{ $record->coffee_sample_name }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Lot Number</dt>
                    <dd>{{ $record->lot_number }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Asal</dt>
                    <dd>{{ $record->origin }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Varietas</dt>
                    <dd>{{ $record->variety }}</dd>
                </div>
                <div class="text-center">
                    <dt class="font-semibold">Ketinggian</dt>
                    <dd>{{ $record->altitude }}</dd>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section heading="Ringkasan Nilai Rata-Rata">
            @livewire('hpq-score-summary', ['record' => $record])
        </x-filament::section>
    </div>
</x-filament::page>
