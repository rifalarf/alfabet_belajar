<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Hasil Ulangan') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row gap-8">
                            {{-- Kolom Kiri: Foto Wajah --}}
                            <div class="w-full md:w-1/3">
                                <h3 class="text-lg font-semibold mb-2">Foto Verifikasi</h3>
                                @if($result->face_image_path)
                                    <img src="{{ $result->face_image_path }}" alt="Foto Wajah {{ $result->student_name }}" class="rounded-lg shadow-md w-full">
                                @else
                                    <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                                        <span>Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Kolom Kanan: Detail Informasi --}}
                            <div class="w-full md:w-2/3">
                                <h3 class="text-lg font-semibold mb-4">Informasi Siswa & Ulangan</h3>
                                <div class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nama Siswa</dt>
                                        <dd class="mt-1 text-lg text-gray-900">{{ $result->student_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Judul Ulangan</dt>
                                        <dd class="mt-1 text-lg text-gray-900">{{ $result->exam->title }} ({{ $result->exam->code }})</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Skor Akhir</dt>
                                        <dd class="mt-1 text-2xl font-bold text-indigo-600">{{ $result->score }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Waktu Mengerjakan</dt>
                                        <dd class="mt-1 text-lg text-gray-900">{{ $result->created_at->format('d M Y, H:i') }}</dd>
                                    </div>
                                </div>
                                <div class="mt-6 border-t pt-4">
                                     <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                        Kembali ke Dasbor
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
