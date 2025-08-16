<x-app-layout>
    <x-slot name="header">
        @once
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&display=swap" rel="stylesheet">
            <style>
                .exam-title {
                    font-family: 'Baloo 2', cursive;
                    font-size: 56pt;
                    line-height: 1;
                    font-weight: 700;
                    color: #0099b4;
                }
                @media (max-width:1024px){ .exam-title { font-size:40pt; } }
                @media (max-width:640px){ .exam-title { font-size:30pt; } }
            </style>
        @endonce
        <div class="flex items-center gap-6">
            <img src="{{ asset('assets/images/ulangan_header.png') }}" alt="Ulangan" class="h-20">
            <span class="exam-title">{{ $examResult->exam->title }}</span>
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

        .question-nav-item.active {
            background-color: #16a34a !important;
            color: white !important;
            border-color: #16a34a;
            transition: all 0.2s;
        }

        .question-nav-item::after {
            content: '\2713';
            position: absolute;
            font-size: 0.75rem;
            color: white;
            top: 2px;
            right: 4px;
            display: none;
        }

        .question-nav-item.active::after {
            display: block;
        }

        .question-section {
            display: none;
            opacity: 0;
            transform: translateX(20px);
            transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
        }

        .question-section.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
            animation: slideInFade 0.5s ease-out forwards;
        }

        .question-section.fade-out {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        @keyframes slideInFade {
            0% {
                opacity: 0;
                transform: translateX(30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutFade {
            0% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(-30px);
            }
        }

        .question-section.slide-out {
            animation: slideOutFade 0.3s ease-in forwards;
        }

        .question-container {
            position: relative;
            min-height: 400px;
        }

        .transition-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 10;
        }

        .transition-overlay.active {
            opacity: 1;
        }

        .transition-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Timer Styles */
        .timer-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 16px;
        }

        .timer-display {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            color: #1f2937;
        }

        .timer-warning {
            color: #f59e0b !important;
            animation: pulse 1s infinite;
        }

        .timer-critical {
            color: #ef4444 !important;
            animation: pulse 0.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .timer-bar {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
        }

        .timer-progress {
            height: 100%;
            background-color: #10b981;
            border-radius: 3px;
            transition: width 1s ease-linear, background-color 0.3s ease;
        }

        .timer-progress.warning {
            background-color: #f59e0b;
        }

        .timer-progress.critical {
            background-color: #ef4444;
        }

        .timer-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .timer-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .timer-modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            margin: 20px;
        }
    </style>

    <div class="min-h-screen" style="background-image: url('{{ asset('assets/images/bg_soal.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="timer-container">
            <div class="timer-display" id="timer-display">15:00</div>
            <div class="timer-bar">
                <div class="timer-progress" id="timer-progress" style="width: 100%"></div>
            </div>
            <div class="text-xs text-gray-500 text-center mt-2">Waktu Tersisa</div>
        </div>

        <div class="timer-modal" id="timer-modal">
            <div class="timer-modal-content">
                <h3 class="text-xl font-bold text-red-600 mb-4">Waktu Habis!</h3>
                <p class="text-gray-700 mb-4">Ujian telah berakhir. Sistem akan otomatis menyimpan jawaban Anda.</p>
                <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <div class="question-container">
                        <div class="transition-overlay" id="transition-overlay">
                            <div class="transition-spinner"></div>
                        </div>

                        @forelse($questions as $index => $question)
                        <div id="question-{{ $question->id }}" class="question-section bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8 {{ $index === 0 ? 'active' : '' }}">
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
                                            tabindex="0"
                                            data-is-correct="{{ $option->alphabet_id == $question->correctAnswer->id ? 'true' : 'false' }}"
                                            data-question-id="{{ $question->id }}">
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
                                        <div class="option-wrapper rounded-lg border-2 border-gray-200 bg-white p-1 shadow-sm answer-option"
                                            tabindex="0"
                                            data-is-correct="{{ $option->alphabet_id == $question->correctAnswer->id ? 'true' : 'false' }}"
                                            data-question-id="{{ $question->id }}">
                                            <video src="{{ asset($option->alphabet->video_path) }}" class="w-full h-auto rounded-md aspect-video" controls></video>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="flex justify-between px-6 pb-6">
                                <button class="nav-btn-prev w-16 h-16 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-110" data-index="{{ $index }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button class="nav-btn-next w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-110" data-index="{{ $index }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-12 text-gray-500 text-center">
                                <h3 class="text-lg font-medium">Oops!</h3>
                                <p>Soal untuk ulangan ini belum disiapkan oleh guru.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-12 flex justify-center">
                        <button id="finish-exam-btn"
                            data-exam-result-id="{{ $examResult->id }}"
                            data-total-questions="{{ $questions->count() }}"
                            class="flex items-center justify-center w-full max-w-4xl bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 py-6"
                            aria-label="Selesai Ulangan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-56">
                    <div class="sticky top-24 space-y-4">
                        <div class="bg-white rounded-xl shadow-md p-4">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Navigasi Soal</h4>
                            <div id="question-nav" class="flex flex-wrap gap-2">
                                @foreach($questions as $index => $q)
                                <button
                                    class="question-nav-item relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-400 text-sm font-bold text-gray-700 hover:bg-blue-100 transition-all duration-200 transform hover:scale-110"
                                    data-target="question-{{ $q->id }}"
                                    data-index="{{ $index }}"
                                    id="nav-item-{{ $q->id }}">
                                    {{ $index + 1 }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userAnswers = {};
            const finishButton = document.getElementById('finish-exam-btn');
            const allQuestions = document.querySelectorAll('.question-section');
            const transitionOverlay = document.getElementById('transition-overlay');
            let isTransitioning = false;
            let examFinished = false;

            const EXAM_DURATION = 15 * 60; // 15 minutes in seconds
            let timeRemaining = EXAM_DURATION;
            const timerDisplay = document.getElementById('timer-display');
            const timerProgress = document.getElementById('timer-progress');
            const timerModal = document.getElementById('timer-modal');

            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            function updateTimerDisplay() {
                timerDisplay.textContent = formatTime(timeRemaining);

                const percentage = (timeRemaining / EXAM_DURATION) * 100;
                timerProgress.style.width = percentage + '%';

                timerDisplay.classList.remove('timer-warning', 'timer-critical');
                timerProgress.classList.remove('warning', 'critical');

                if (timeRemaining <= 60) { // Last minute - critical
                    timerDisplay.classList.add('timer-critical');
                    timerProgress.classList.add('critical');
                } else if (timeRemaining <= 300) { // Last 5 minutes - warning
                    timerDisplay.classList.add('timer-warning');
                    timerProgress.classList.add('warning');
                }
            }

            function startTimer() {
                const timerInterval = setInterval(() => {
                    if (examFinished) {
                        clearInterval(timerInterval);
                        return;
                    }

                    timeRemaining--;
                    updateTimerDisplay();

                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        timeUp();
                    }
                }, 1000);
            }

            function timeUp() {
                examFinished = true;
                timerModal.classList.add('active');

                document.querySelectorAll('.answer-option, .answer-option-img, .nav-btn-next, .nav-btn-prev, .question-nav-item').forEach(el => {
                    el.style.pointerEvents = 'none';
                    el.style.opacity = '0.5';
                });

                setTimeout(() => {
                    submitExamAutomatically();
                }, 2000);
            }

            function submitExamAutomatically() {
                const correctAnswersCount = Object.values(userAnswers).filter(ans => ans === true).length;

                fetch('{{ route("ulangan.storeResult") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            exam_result_id: finishButton.dataset.examResultId,
                            total_questions: finishButton.dataset.totalQuestions,
                            correct_answers: correctAnswersCount,
                            time_up: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.result_id) {
                            window.location.href = `/ulangan/hasil/${data.result_id}`;
                        } else {
                            alert('Gagal menyimpan hasil ujian.');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan hasil.');
                        location.reload();
                    });
            }

            updateTimerDisplay();
            startTimer();

            window.addEventListener('beforeunload', function(e) {
                if (!examFinished) {
                    e.preventDefault();
                    e.returnValue = 'Ujian sedang berlangsung. Yakin ingin meninggalkan halaman?';
                    return e.returnValue;
                }
            });

            function showQuestion(index, withTransition = true) {
                if (isTransitioning || examFinished) return;

                const currentActive = document.querySelector('.question-section.active');
                const targetQuestion = allQuestions[index];

                if (!targetQuestion || currentActive === targetQuestion) return;

                if (withTransition) {
                    isTransitioning = true;

                    transitionOverlay.classList.add('active');

                    if (currentActive) {
                        currentActive.classList.add('slide-out');

                        setTimeout(() => {
                            currentActive.classList.remove('active', 'slide-out');

                            setTimeout(() => {
                                targetQuestion.classList.add('active');
                                transitionOverlay.classList.remove('active');
                                isTransitioning = false;
                            }, 150);
                        }, 300);
                    } else {
                        setTimeout(() => {
                            targetQuestion.classList.add('active');
                            transitionOverlay.classList.remove('active');
                            isTransitioning = false;
                        }, 200);
                    }
                } else {
                    allQuestions.forEach(q => q.classList.remove('active'));
                    targetQuestion.classList.add('active');
                }
            }

            document.querySelectorAll('.nav-btn-next').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (examFinished) return;
                    const index = parseInt(btn.dataset.index);
                    if (index + 1 < allQuestions.length) {
                        showQuestion(index + 1);
                    }
                });
            });

            document.querySelectorAll('.nav-btn-prev').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (examFinished) return;
                    const index = parseInt(btn.dataset.index);
                    if (index - 1 >= 0) {
                        showQuestion(index - 1);
                    }
                });
            });

            document.querySelectorAll('.question-nav-item').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (examFinished) return;
                    const targetIndex = parseInt(btn.dataset.index);
                    showQuestion(targetIndex);
                });
            });

            document.addEventListener('keydown', function(e) {
                if (isTransitioning || examFinished) return;

                const currentIndex = Array.from(allQuestions).findIndex(q => q.classList.contains('active'));

                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (currentIndex + 1 < allQuestions.length) {
                        showQuestion(currentIndex + 1);
                    }
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (currentIndex - 1 >= 0) {
                        showQuestion(currentIndex - 1);
                    }
                }
            });

            allQuestions.forEach(questionDiv => {
                const answerOptions = questionDiv.querySelectorAll('.answer-option, .answer-option-img');

                answerOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        if (examFinished) return;

                        const isCorrect = this.dataset.isCorrect === 'true';
                        const questionId = this.dataset.questionId;

                        userAnswers[questionId] = isCorrect;

                        answerOptions.forEach(btn => btn.classList.remove('selected'));
                        this.classList.add('selected');

                        const navBtn = document.getElementById(`nav-item-${questionId}`);
                        if (navBtn) navBtn.classList.add('active');
                    });
                });
            });

            finishButton.addEventListener('click', function() {
                if (examFinished) return;

                if (Object.keys(userAnswers).length < allQuestions.length) {
                    alert('Harap jawab semua soal terlebih dahulu!');
                    return;
                }

                if (!confirm('Yakin ingin menyelesaikan ujian sekarang?')) {
                    return;
                }

                examFinished = true;
                this.disabled = true;

                const correctAnswersCount = Object.values(userAnswers).filter(ans => ans === true).length;

                fetch('{{ route("ulangan.storeResult") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            exam_result_id: this.dataset.examResultId,
                            total_questions: this.dataset.totalQuestions,
                            correct_answers: correctAnswersCount,
                            time_remaining: timeRemaining
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.result_id) {
                            window.location.href = `/ulangan/hasil/${data.result_id}`;
                        } else {
                            this.disabled = false;
                            examFinished = false;
                            alert('Gagal menyimpan hasil.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.disabled = false;
                        examFinished = false;
                        alert('Terjadi kesalahan.');
                    });
            });
        });
    </script>
</x-app-layout>