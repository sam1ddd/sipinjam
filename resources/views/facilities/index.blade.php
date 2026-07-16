<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Fasilitas
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
                    <h3 class="text-lg font-semibold">Daftar Fasilitas</h3>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('facilities.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Tambah Fasilitas
                        </a>
                    @endif
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Kapasitas</th>
                            <th class="p-3">Lokasi</th>
                            <th class="p-3">Status</th>
                            @if (auth()->user()->isAdmin())
    <th class="p-3">Aksi</th>
@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($facilities as $facility)
                            <tr class="border-b">
                                <td class="p-3">{{ $facility->name }}</td>
                                <td class="p-3">{{ $facility->category }}</td>
                                <td class="p-3">{{ $facility->capacity ?? '-' }}</td>
                                <td class="p-3">{{ $facility->location }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs {{ $facility->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $facility->status }}
                                    </span>
                                </td>
@if (auth()->user()->isAdmin())
    <td class="p-3 space-x-2">
        <a href="{{ route('facilities.edit', $facility) }}" class="text-blue-600 hover:underline">Edit</a>
        <form action="{{ route('facilities.destroy', $facility) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus fasilitas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
        </form>
    </td>
@endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="p-3 text-center text-gray-500">Belum ada data fasilitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $facilities->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>