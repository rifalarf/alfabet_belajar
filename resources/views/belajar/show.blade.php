<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Belajar Huruf: ') . $alphabet->letter }}
        </h2>
    </x-slot>

    <div class="min-h-screen" style="background-image: url('{{ asset('assets/images/bg_soal.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row items-center gap-8">

                        <div class="w-full md:w-5/12 flex justify-center">
                            <div class="w-full max-w-sm bg-gray-100 p-4 rounded-lg shadow-inner">
                                <img src="{{ asset($alphabet->image_path) }}" alt="Gambar huruf {{ $alphabet->letter }}" class="w-full h-auto object-contain">
                            </div>
                        </div>

                        <div class="w-full md:w-7/12">
                            <video src="{{ asset($alphabet->video_path) }}" controls class="w-full rounded-lg shadow-md aspect-video"></video>
                        </div>

                    </div>

                    <div class="mt-8">
                        <a href="{{ route('belajar.index') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-gray-100 p-2 shadow-md transition-transform duration-300 hover:bg-gray-200 hover:scale-110">
                            <img src="{{ asset('assets/images/back.png') }}" alt="Kembali" class="h-24 w-24 object-contain">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>