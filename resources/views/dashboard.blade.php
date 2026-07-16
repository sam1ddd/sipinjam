<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (auth()->user()->isAdmin())
                {{-- DASHBOARD ADMIN --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_facilities'] }}</p>
                        <p class="text-sm text-gray-500">Total Fasilitas</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                        <p class="text-sm text-gray-500">Total Pengajuan</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        <p class="text-sm text-gray-500">Pending</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                        <p class="text-sm text-gray-500">Disetujui</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                        <p class="text-sm text-gray-500">Ditolak</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4">Fasilitas Paling Sering Dipinjam</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-2">Nama Fasilitas</th>
                                <th class="p-2">Jumlah Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($popularFacilities as $facility)
                                <tr class="border-b">
                                    <td class="p-2">{{ $facility->name }}</td>
                                    <td class="p-2">{{ $facility->bookings_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="p-2 text-gray-500">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                {{-- DASHBOARD USER --}}
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-2">Selamat datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 mb-4">Berikut 5 pengajuan peminjaman terakhir kamu.</p>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-2">Fasilitas</th>
                                <th class="p-2">Waktu</th>
                                <th class="p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($myBookings as $booking)
                                <tr class="border-b">
                                    <td class="p-2">{{ $booking->facility->name }}</td>
                                    <td class="p-2 text-sm">{{ $booking->start_time->format('d M Y H:i') }}</td>
                                    <td class="p-2">
                                        @php
                                            $badge = match($booking->status) {
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                default => 'bg-yellow-100 text-yellow-700',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $badge }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="p-2 text-gray-500">Belum ada pengajuan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="{{ route('bookings.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Ajukan Peminjaman Baru
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>