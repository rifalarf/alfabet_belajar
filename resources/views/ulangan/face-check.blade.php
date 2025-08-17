<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <img src="{{ asset('assets/images/verifikasi_wajah.png') }}" alt="Verifikasi Wajah" class="h-16">
        </h2>
    </x-slot>

    <div class="min-h-screen" style="
        background-image: url('/assets/images/background.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;">
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-800">Satu Langkah Lagi!</h3>
                        <p class="mt-2 text-gray-600">
                            Posisikan wajah Anda di dalam area kamera, lalu tekan tombol di bawah.
                        </p>
                        @if($exam->end_date)
                        <p class="text-sm text-gray-500 mt-2">Periode: {{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}</p>
                        @endif

                        {{-- Area untuk menampilkan stream kamera --}}
                        <div class="mt-6 w-full max-w-md mx-auto bg-gray-900 rounded-lg overflow-hidden">
                            <video id="camera-stream" autoplay playsinline class="w-full h-auto"></video>
                        </div>
                        {{-- Canvas tersembunyi untuk mengambil gambar --}}
                        <canvas id="camera-capture" class="hidden"></canvas>

                        <div class="mt-6">
                            <button id="capture-btn"
                                class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('camera-stream');
            const canvas = document.getElementById('camera-capture');
            const captureBtn = document.getElementById('capture-btn');
            const context = canvas.getContext('2d');

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function(error) {
                        console.error("Error accessing camera: ", error);
                        alert('Tidak bisa mengakses kamera. Pastikan Anda memberikan izin.');
                    });
            }

            captureBtn.addEventListener('click', function() {
                this.disabled = true;
                this.textContent = 'Memproses...';

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('image', blob, 'face-capture.png');

                    const url = '{{ route("ulangan.store-face-image", ["exam" => $exam]) }}';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => {
                            // Cek apakah responsnya JSON atau teks biasa (untuk error)
                            const contentType = response.headers.get("content-type");
                            if (response.ok && contentType && contentType.indexOf("application/json") !== -1) {
                                return response.json();
                            }
                            // Jika bukan JSON, kemungkinan besar ini adalah halaman error HTML
                            return response.text().then(text => {
                                throw new Error(text || 'Server returned a non-JSON response.');
                            });
                        })
                        .then(data => {
                            if (data.success && data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                // Gunakan pesan error dari server jika ada
                                throw new Error(data.message || 'Upload failed');
                            }
                        })
                        .catch(error => {
                            // Tampilkan error yang lebih detail di console
                            console.error('Detailed Error:', error);
                            alert('Gagal mengunggah foto. Silakan coba lagi dan cek console browser untuk detail.');
                            captureBtn.disabled = false;
                            captureBtn.textContent = 'Ambil Foto & Lanjutkan';
                        });
                }, 'image/png');
            });
        });
    </script>
</x-app-layout>