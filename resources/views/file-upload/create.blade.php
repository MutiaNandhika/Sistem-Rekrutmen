@extends('layouts.public')

@section('title', 'Upload File')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div
            class="bg-white p-8 rounded-xl shadow-lg w-full max-w-xl mx-auto transform transition duration-500 hover:scale-[1.01]">
            <h2
                class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-6 text-center">
                Upload File
            </h2>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"
                    role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama Anda" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-semibold text-gray-700 mb-1">File Upload</label>
                    <div class="relative group">
                        <input type="file" name="file" id="file" required
                            class="w-full text-sm text-gray-500
                        file:mr-4 file:py-3 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all rounded-lg border border-gray-300 shadow-sm bg-gray-50 @error('file') border-red-500 @enderror">
                    </div>
                    @error('file')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-400 text-xs mt-2">Maksimal 10MB (JPG, PNG, PDF, DOC, DOCX)</p>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    🚀 Upload Data
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white p-8 rounded-xl shadow-lg overflow-hidden">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Daftar Data & File</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-50 text-indigo-800 border-b border-indigo-200">
                            <th class="py-3 px-4 font-semibold text-sm rounded-tl-lg">#</th>
                            <th class="py-3 px-4 font-semibold text-sm">Nama Lengkap</th>
                            <th class="py-3 px-4 font-semibold text-sm">File</th>
                            <th class="py-3 px-4 font-semibold text-sm rounded-tr-lg">Waktu Upload</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-600 text-sm">
                        @forelse($uploads as $index => $upload)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 font-medium">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-gray-800 font-semibold">{{ $upload->name }}</td>
                                <td class="py-4 px-4">
                                    <a href="{{ Storage::disk('s3')->url($upload->file_path) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-xs font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                        Buka File
                                    </a>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-500">{{ $upload->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-500 italic">Belum ada data yang
                                    tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
