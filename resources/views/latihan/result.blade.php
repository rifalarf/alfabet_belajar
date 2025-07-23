<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <img src="{{ asset('assets/images/hasil_latihan.png') }}" alt="Pilih Huruf untuk Dipelajari" class="h-12">

        </h2>
    </x-slot>
    <div class="min-h-screen" style="background-image: url('{{ asset('assets/images/bg_soal.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg text-center p-8">
                    <h3 class="text-2xl font-bold text-gray-800">Latihan Selesai!</h3>
                    <p class="text-gray-600 mt-2">Level: {{ $result->level->name }}</p>

                    <div class="my-8">
                        <div class="text-6xl font-bold text-blue-600">{{ $result->score }}</div>
                        <div class="text-lg font-medium text-gray-500">Total Skor</div>
                    </div>

                    <div class="flex justify-around border-t border-b py-4">
                        <div>
                            <div class="flex items-center justify-center gap-2 text-2xl font-bold text-green-600">
                                <span>{{ $result->correct_answers }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div>
                            <div class="flex items-center justify-center gap-2 text-2xl font-bold text-red-600">
                                <span>{{ $result->total_questions - $result->correct_answers }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>

                        <div>
                            <div class="text-2xl font-bold">{{ $result->total_questions }}</div>
                            <div class="text-sm text-gray-500 mt-1">Total Soal</div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center items-center gap-4">
                        <a href="{{ route('latihan.show', $result->level) }}" title="Ulangi Latihan" class="p-4 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-100 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/ulangi.png') }}" alt="Ulangi Latihan" class="h-8 w-8">
                        </a>
                        <a href="{{ route('latihan.index') }}" title="Pilih Level Lain" class="p-4 bg-blue-600 border border-transparent rounded-full shadow-sm hover:bg-blue-500 transition-transform duration-300 hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>