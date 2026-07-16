<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Pengajuan Peminjaman
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

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Pemohon</th>
                            <th class="p-3">Fasilitas</th>
                            <th class="p-3">Keperluan</th>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-b">
                                <td class="p-3">{{ $booking->user->name }}</td>
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
                                <td class="p-3">
                                    @if ($booking->status === 'pending')
                                        <div class="flex flex-col gap-2">
                                            <form action="{{ route('bookings.approve', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.reject', $booking) }}" method="POST" class="flex gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="rejection_reason" placeholder="Alasan tolak" required class="text-sm border-gray-300 rounded-md flex-1">
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-gray-500">Belum ada pengajuan.</td>
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