<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ showModal: false, modalImage: '' }">

            @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-8">
                <div class="p-6 sm:px-8 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Sesi Ulangan Anda</h3>
                            <p class="mt-1 text-sm text-gray-500">Daftar semua sesi ulangan yang telah Anda buat.</p>
                        </div>
                        <a href="{{ route('exams.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Buat Ulangan Baru</a>
                    </div>
                </div>
                <div class="p-4 sm:p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul Ulangan</th>
                                    <th scope="col" class="px-6 py-3">Periode Ulangan</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($exams as $exam)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $exam->title }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sesi ulangan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">Anda belum membuat sesi ulangan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rekapitulasi Hasil Siswa -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 sm:px-8 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Rekapitulasi Hasil Siswa</h3>
                    <p class="mt-1 text-sm text-gray-500">Filter dan ekspor semua hasil ulangan yang telah dikerjakan siswa.</p>
                </div>

                <!-- FORM FILTER & EXPORT -->
                <div class="p-6 sm:px-8 bg-gray-50/50">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-full sm:w-auto">
                                <label for="due_date" class="sr-only">Filter Berdasarkan Jadwal Ulangan</label>
                                <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="w-full sm:w-auto">
                                <label for="exam_id" class="sr-only">Filter Berdasarkan Judul Ulangan</label>
                                <select name="exam_id" id="exam_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Semua Ulangan</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                            {{ $exam->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">Filter</button>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">Reset</a>
                            </div>
                            <div class="sm:ml-auto">
                                <a href="{{ route('exam-results.export-pdf', request()->only(['due_date', 'exam_id'])) }}" class="inline-flex items-center w-full sm:w-auto justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">Export PDF</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-0">
                    <!-- Info jumlah hasil -->
                    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                        <p class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $examResults->count() }}</span> hasil ulangan
                            @if(request('exam_id') || request('due_date'))
                                berdasarkan filter yang dipilih
                            @endif
                        </p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Siswa</th>
                                    <th scope="col" class="px-6 py-3">Judul Ulangan</th>
                                    <th scope="col" class="px-6 py-3">Skor</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Mengerjakan</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($examResults as $result)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($result->face_image_path)
                                            <button @click="showModal = true; modalImage = '{{ $result->face_image_path }}'">
                                                <img src="{{ $result->face_image_path }}" alt="Foto" class="w-12 h-12 rounded-lg object-cover cursor-pointer hover:opacity-80 transition-opacity">
                                            </button>
                                            @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                                No Foto
                                            </div>
                                            @endif
                                            <span class="font-medium text-gray-900">{{ $result->student_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-900">{{ $result->exam->title }}</span>
                                        <br>
                                        <!-- <span class="text-xs text-gray-500">Kode: {{ $result->exam->code }}</span> -->
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $result->score }}</td>
                                    <td class="px-6 py-4">{{ $result->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="">
                                            <form method="POST" action="{{ route('exam-results.destroy', $result) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hasil ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        @if(request('exam_id') || request('due_date'))
                                            Tidak ada hasil ulangan yang cocok dengan filter yang dipilih.
                                        @else
                                            Belum ada hasil ulangan yang dikerjakan oleh siswa.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW FOTO -->
    <div x-show="showModal" style="display: none;" @keydown.escape.window="showModal = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4 transition-opacity duration-300" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="showModal = false" class="relative bg-white p-4 rounded-lg shadow-xl max-w-2xl w-full transition-transform duration-300" x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <button @click="showModal = false" class="absolute -top-3 -right-3 text-white bg-gray-800 rounded-full p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img :src="modalImage" alt="Preview Foto Siswa" class="w-full h-auto rounded-md">
        </div>
    </div>
</x-app-layout>