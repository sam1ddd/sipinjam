<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Peminjaman
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Pilih Fasilitas</label>
                        <select name="facility_id" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="">-- Pilih Fasilitas --</option>
                            @foreach ($facilities as $facility)
                                <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                    {{ $facility->name }} ({{ $facility->category }} - {{ $facility->location }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Keperluan</label>
                        <textarea name="purpose" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Contoh: Rapat organisasi himpunan mahasiswa">{{ old('purpose') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Pengajuan</button>
                        <a href="{{ route('bookings.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>