<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Fasilitas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('facilities.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nama Fasilitas</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kategori</label>
                        <input type="text" name="category" value="{{ old('category') }}" placeholder="Contoh: Ruangan, Alat Elektronik" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kapasitas (opsional)</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('capacity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('facilities.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>