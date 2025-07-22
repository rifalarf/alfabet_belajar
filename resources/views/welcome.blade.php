<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Belajar Alfabet</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="relative min-h-screen bg-gray-50 text-black/50 overflow-hidden">
        {{-- Header --}}
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5 flex items-center gap-2">
                    </a>
                </div>
                <div class="lg:flex lg:flex-1 lg:justify-end items-center">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="rounded-md px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100">
                        Masuk ke Dasbor
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                        Login Guru
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Register Guru
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </nav>
        </header>

        <main class="relative isolate px-6">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>

            <div class="mx-auto max-w-2xl flex items-center justify-center min-h-screen">
                <div class="text-center">
                    <img src="{{ asset('assets/images/logo-yayasan.png') }}" alt="Logo Yayasan" class="mx-auto h-32 w-auto mb-8">
                    <img src="{{ asset('assets/images/belajar_alfabet.png') }}" alt="Belajar Alfabet" class="mx-auto h- w-auto">

                    <p class="mt-6 text-lg leading-8 text-gray-600">Silakan pilih menu di bawah ini untuk memulai.</p>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <a href="{{ route('belajar.index') }}" class="group block rounded-xl border border-gray-200 bg-blue-50 p-4 shadow-lg transition-all duration-300 hover:bg-blue-100 hover:border-blue-500 hover:ring-2 hover:ring-blue-300">
                            <img src="{{ asset('assets/images/Belajar.png') }}" alt="Mulai Belajar" class="mx-auto h-24 w-auto">
                            <p class="mt-3 text-center font-semibold text-gray-700 group-hover:text-blue-600">Belajar</p>
                        </a>
                        <a href="{{ route('latihan.index') }}" class="group block rounded-xl border border-gray-200 bg-green-50 p-4 shadow-lg transition-all duration-300 hover:bg-green-100 hover:border-green-500 hover:ring-2 hover:ring-green-300">
                            <img src="{{ asset('assets/images/Latihan.png') }}" alt="Mulai Latihan" class="mx-auto h-24 w-auto">
                            <p class="mt-3 text-center font-semibold text-gray-700 group-hover:text-green-600">Latihan</p>
                        </a>
                        <a href="{{ route('ulangan.index') }}" class="group block rounded-xl border border-gray-200 bg-gray-100 p-4 shadow-lg transition-all duration-300 hover:bg-gray-200 hover:border-gray-500 hover:ring-2 hover:ring-gray-300">
                            <img src="{{ asset('assets/images/Ulangan.png') }}" alt="Mulai Ulangan" class="mx-auto h-24 w-auto">
                            <p class="mt-3 text-center font-semibold text-gray-700 group-hover:text-gray-600">Ulangan</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)] hidden" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
        </main>
    </div>
</body>

</html>