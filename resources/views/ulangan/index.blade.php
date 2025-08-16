<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <img src="{{ asset('assets\images\hasil_ulangan.png') }}" alt="Pilih Huruf untuk Dipelajari" class="h-16">

        </h2>
    </x-slot>
    <div class="min-h-screen" style="
        background-image: url('/assets/images/background.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Ulangan yang Tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Pilih ulangan yang ingin Anda kerjakan.</p>
                    </div>

                    <div class="p-6">
                        @if($activeExams->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($activeExams as $exam)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Periode:</span> {{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Guru:</span> {{ $exam->user->name ?? 'Guru' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Status:</span>
                                            @if($exam->status == 'active')
                                            <span class="text-green-600">Aktif</span>
                                            @elseif($exam->status == 'pending')
                                            <span class="text-yellow-600">Menunggu</span>
                                            @else
                                            <span class="text-red-600">Selesai</span>
                                            @endif
                                        </p>
                                    </div>

                                    <a href="{{ route('ulangan.face-check', $exam) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mulai Ulangan
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Ulangan Aktif</h3>
                            <p class="text-gray-500">Saat ini tidak ada ulangan yang sedang berlangsung.</p>
                            <div class="mt-6">
                                <a href="/" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>