<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Ulangan') }}
        </h2>
    </x-slot>

    <div class="min-h-screen" style="background-image: url('{{ asset('assets/images/bg_soal.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg text-center p-8">

                    <h3 class="text-2xl font-bold text-gray-800">Ulangan Selesai!</h3>
                    <p class="text-gray-600 mt-2">Berikut adalah hasil ulangan Anda, {{ $examResult->student_name }}.</p>

                    {{-- Visualisasi Skor --}}
                    <div class="my-8">
                        <div class="text-6xl font-bold text-indigo-600">{{ $examResult->score }}</div>
                        <div class="text-lg font-medium text-gray-500">Total Skor</div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        {{-- PERBAIKAN DI SINI: Mengarahkan ke route 'ulangan.index' --}}
                        <a href="{{ route('ulangan.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Selesai
                        </a>
                        <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>