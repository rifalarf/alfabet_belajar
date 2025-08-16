<x-app-layout>
    <x-slot name="header">
        @php
            // Ambil huruf terakhir dari nama level, contoh "Level A" -> "a"
            $levelLetter = strtolower(substr(trim($level->name), -1));
            $imagePath = 'assets/images/level_' . $levelLetter . '.png';
        @endphp
        <div class="flex items-center gap-4">
            <img src="{{ asset($imagePath) }}" alt="{{ $level->name }}" class="h-16">
            <span class="sr-only">{{ $level->name }}</span>
        </div>
    </x-slot>

    <style>
        .option-wrapper {
            position: relative;
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .option-wrapper:hover {
            transform: scale(1.03);
        }

        .option-wrapper.selected {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.4);
        }

        .option-wrapper.selected::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg fill='white' stroke='green' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7' /%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>


    <div class="min-h-screen" style="background-image: url('{{ asset('assets/images/bg_soal.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                @forelse($questions as $index => $question)
                <div id="question-{{ $question->id }}" class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <img src="{{ asset('assets/images/soal.png') }}" alt="Pilih Huruf untuk Dipelajari" class="h-9">

                            <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-800">
                                {{ $index + 1 }} dari {{ $questions->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($question->type == 'video_to_image')
                        <div class="text-center mb-6">
                            <p class="text-gray-600">Perhatikan video berikut dan pilih gambar yang benar!</p>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="w-full md:w-2/5 flex justify-center">
                                <div class="w-full max-w-sm bg-gray-50 p-2 rounded-xl shadow-inner border">
                                    <video src="{{ asset($question->correctAnswer->video_path) }}" controls class="w-full h-auto rounded-md"></video>
                                </div>
                            </div>
                            <div class="w-full md:w-3/5 grid grid-cols-2 gap-4">
                                @foreach($question->options as $option)
                                <div class="option-wrapper rounded-lg border-2 border-gray-200 bg-white p-2 shadow-sm answer-option-img"
                                    data-is-correct="{{ $option->alphabet_id == $question->correctAnswer->id ? 'true' : 'false' }}">
                                    <img src="{{ asset($option->alphabet->image_path) }}" alt="Pilihan" class="w-full h-auto rounded-md">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @elseif($question->type == 'image_to_video')
                        <div class="text-center mb-6">
                            <p class="text-gray-600">Perhatikan gambar berikut dan pilih video yang benar!</p>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="w-full md:w-1/3 flex justify-center">
                                <div class="w-full max-w-xs bg-gray-50 p-4 rounded-xl shadow-inner border">
                                    <img src="{{ asset($question->correctAnswer->image_path) }}" alt="Soal" class="w-full h-auto object-contain">
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 grid grid-cols-2 gap-4">
                                @foreach($question->options as $option)
                                <div class="option-wrapper rounded-lg border-2 border-gray-200 bg-white p-2 shadow-sm answer-option"
                                    data-is-correct="{{ $option->alphabet_id == $question->correctAnswer->id ? 'true' : 'false' }}">
                                    <video src="{{ asset($option->alphabet->video_path) }}" class="w-full h-auto rounded-md aspect-video" controls></video>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-gray-500 text-center">
                        <h3 class="text-lg font-medium">Oops!</h3>
                        <p>Soal untuk level ini belum tersedia.</p>
                    </div>
                </div>
                @endforelse
                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('latihan.index') }}"
                        class="flex items-center justify-center w-20 h-20 bg-white border border-gray-300 rounded-xl shadow-lg hover:bg-gray-100 transition"
                        aria-label="Kembali ke daftar latihan">
                        <img src="{{ asset('assets/images/back.png') }}" alt="Kembali" class="w-10 h-10">
                    </a>
                    <button id="finish-practice-btn"
                        data-level-id="{{ $level->id }}"
                        data-total-questions="{{ $questions->count() }}"
                        aria-label="Selesai Latihan"
                        class="flex items-center justify-center w-20 h-20 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userAnswers = {};
            const finishButton = document.getElementById('finish-practice-btn');
            const allQuestions = document.querySelectorAll('[id^="question-"]');

            allQuestions.forEach(questionDiv => {
                const answerOptions = questionDiv.querySelectorAll('.answer-option, .answer-option-img');

                answerOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const isCorrect = this.dataset.isCorrect === 'true';
                        const questionId = questionDiv.id;

                        userAnswers[questionId] = isCorrect;

                        answerOptions.forEach(btn => {
                            btn.classList.remove('selected');
                        });

                        this.classList.add('selected');
                    });
                });
            });

            finishButton.addEventListener('click', function() {
                if (Object.keys(userAnswers).length < allQuestions.length) {
                    alert('Harap jawab semua soal terlebih dahulu!');
                    return;
                }

                this.disabled = true;
                this.textContent = 'Menyimpan...';

                const correctAnswersCount = Object.values(userAnswers).filter(ans => ans === true).length;

                fetch('{{ route("latihan.storeResult") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            level_id: this.dataset.levelId,
                            total_questions: this.dataset.totalQuestions,
                            correct_answers: correctAnswersCount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.result_id) {
                            window.location.href = `/latihan/hasil/${data.result_id}`;
                        } else {
                            this.disabled = false;
                            this.textContent = 'Selesai Latihan';
                            alert('Gagal menyimpan hasil.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.disabled = false;
                        this.textContent = 'Selesai Latihan';
                        alert('Terjadi kesalahan.');
                    });
            });
        });
    </script>
</x-app-layout>