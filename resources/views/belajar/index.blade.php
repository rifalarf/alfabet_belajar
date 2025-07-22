<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <img src="{{ asset('assets/images/belajar_huruf.png') }}" alt="Pilih Huruf untuk Dipelajari" class="h-16">

        </h2>
    </x-slot>

    <div class="min-h-screen" style="
        background-image: url('/assets/images/background.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-center">
                            <div class="inline-grid grid-cols-6 gap-4">
                                @foreach ($alphabets as $alphabet)
                                <a href="{{ route('belajar.show', $alphabet) }}"
                                    class="block p-3 bg-gradient-to-br from-blue-50/95 to-blue-100/95 border border-blue-200 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:from-blue-100/95 hover:to-blue-150/95 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 backdrop-blur-sm">
                                    <img src="{{ asset($alphabet->image_path) }}"
                                        alt="Huruf {{ $alphabet->letter }}"
                                        class="w-full h-auto object-contain rounded-md">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>