<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <img src="{{ asset('assets/images/pilih_level.png') }}" alt="Pilih Huruf untuk Dipelajari" class="h-16">

        </h2>
    </x-slot>

    <style>
        .level-card {
            position: relative;
            overflow: hidden;
        }

        .level-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--level-color-start), var(--level-color-end));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .level-card:hover::before {
            transform: scaleX(1);
        }

        .level-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .level-card:hover .level-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .level-letter {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, var(--level-color-start), var(--level-color-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dasharray 0.3s ease;
        }

        .level-a {
            --level-color-start: #10b981;
            --level-color-end: #059669;
        }

        .level-b {
            --level-color-start: #3b82f6;
            --level-color-end: #2563eb;
        }

        .level-c {
            --level-color-start: #f59e0b;
            --level-color-end: #d97706;
        }

        .level-d {
            --level-color-start: #ef4444;
            --level-color-end: #dc2626;
        }

        .level-e {
            --level-color-start: #8b5cf6;
            --level-color-end: #7c3aed;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.1;
            transition: opacity 0.3s ease;
        }

        .level-card:hover .floating-elements {
            opacity: 0.2;
        }
    </style>

    <div class="min-h-screen" style="
        background-image: url('/assets/images/background.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;">

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
               
                    <div class="space-y-4">
                        @forelse ($levels as $index => $level)
                        @php
                        $levelClasses = ['level-a', 'level-b', 'level-c', 'level-d', 'level-e'];
                        $levelIcons = [
                        'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', // Check circle
                        'M13 10V3L4 14h7v7l9-11h-7z', // Lightning bolt
                        'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', // Sun
                        'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z', // Fire
                        'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' // Star
                        ];

                        $levelColors = [
                        'from-green-500 to-green-600',
                        'from-blue-500 to-blue-600',
                        'from-yellow-500 to-yellow-600',
                        'from-red-500 to-red-600',
                        'from-purple-500 to-purple-600'
                        ];
                        $currentClass = $levelClasses[$index % count($levelClasses)];
                        $currentIcon = $levelIcons[$index % count($levelIcons)];
                        $currentColor = $levelColors[$index % count($levelColors)];
                        @endphp

                        <a href="{{ route('latihan.show', $level) }}" class="level-card {{ $currentClass }} group block rounded-2xl border border-gray-200 bg-white shadow-lg transition-all duration-500 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1">
                            <div class="relative p-8">
                                <div class="floating-elements">
                                    <div class="w-32 h-32 rounded-full bg-gradient-to-br {{ $currentColor }} opacity-20"></div>
                                </div>

                                <div class="relative flex items-center gap-8">
                                    <!-- Level Icon & Letter -->
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <!-- Progress Ring -->
                                            <svg class="progress-ring w-24 h-24" viewBox="0 0 100 100">
                                                <circle
                                                    class="progress-ring-circle stroke-gray-200"
                                                    stroke-width="4"
                                                    fill="transparent"
                                                    r="46"
                                                    cx="50"
                                                    cy="50" />
                                                <circle
                                                    class="progress-ring-circle"
                                                    stroke="url(#gradient-{{ $index }})"
                                                    stroke-width="4"
                                                    fill="transparent"
                                                    r="46"
                                                    cx="50"
                                                    cy="50"
                                                    stroke-dasharray="0 289"
                                                    style="transition: stroke-dasharray 0.5s ease-in-out;">
                                                </circle>
                                                <defs>
                                                    <linearGradient id="gradient-{{ $index }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                                        <stop offset="0%" style="stop-color:var(--level-color-start)" />
                                                        <stop offset="100%" style="stop-color:var(--level-color-end)" />
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="level-icon w-12 h-12 rounded-full bg-gradient-to-br {{ $currentColor }} flex items-center justify-center shadow-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $currentIcon }}" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-4 mb-3">
                                            <h3 class="level-letter text-4xl">{{ $level->name }}</h3>
                                        </div>

                                        <div class="flex items-center gap-6 text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                                <span>Tersedia</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 group-hover:bg-gradient-to-br group-hover:{{ $currentColor }} flex items-center justify-center transition-all duration-300">
                                            <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full rounded-2xl border-2 border-dashed border-gray-300 p-16 text-center bg-gray-50">
                            <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Level Tersedia</h3>
                            <p class="text-gray-500">Level latihan akan segera ditambahkan.</p>
                        </div>
                        @endforelse
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const levelCards = document.querySelectorAll('.level-card');

            levelCards.forEach((card, index) => {
                const progressCircle = card.querySelector('.progress-ring-circle:last-child');

                card.addEventListener('mouseenter', () => {
                    const progress = (index + 1) * 20;
                    const circumference = 2 * Math.PI * 46;
                    const strokeDasharray = `${(progress / 100) * circumference} ${circumference}`;
                    progressCircle.style.strokeDasharray = strokeDasharray;
                });

                card.addEventListener('mouseleave', () => {
                    progressCircle.style.strokeDasharray = '0 289';
                });
            });

            levelCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</x-app-layout>