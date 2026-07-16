<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Peminjaman Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Riwayat Saya</h3>
                    <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Ajukan Peminjaman
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Fasilitas</th>
                            <th class="p-3">Keperluan</th>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-b">
                                <td class="p-3">{{ $booking->facility->name }}</td>
                                <td class="p-3">{{ $booking->purpose }}</td>
                                <td class="p-3 text-sm">
                                    {{ $booking->start_time->format('d M Y H:i') }} -
                                    {{ $booking->end_time->format('d M Y H:i') }}
                                </td>
                                <td class="p-3">
                                    @php
                                        $badge = match($booking->status) {
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $badge }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-500">
                                    {{ $booking->rejection_reason ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">Belum ada riwayat peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>