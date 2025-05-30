<div class="w-full bg-white shadow-sm rounded-xl border border-gray-200">
    @if (empty($summary))
        <div class="p-6 text-yellow-600 font-medium">
            ⚠️ Data nilai belum lengkap.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach ($summary as $key => $value)
                            <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wider">
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr>
                        @foreach ($summary as $key => $value)
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                {{ $value }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
