<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        img { width: 60px; height: auto; }
    </style>
</head>
<body>
<h2>Rekap Hasil Ulangan</h2>
<table>
    <thead>
        <tr>
            <th>Foto Siswa</th>
            <th>Judul Ulangan</th>
            <th>Periode Ulangan</th>
            <th>Skor</th>
            <th>Tanggal Mengerjakan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr>
                <td>
                    {{-- PERBAIKAN: Langsung gunakan path karena sudah berupa URL --}}
                    @if($result->face_image_path)
                        <img src="{{ $result->face_image_path }}">
                    @else
                        Tidak ada foto
                    @endif
                </td>
                <td>{{ $result->exam->title ?? 'N/A' }}</td>
                <td>
                    @if($result->exam)
                        {{ \Carbon\Carbon::parse($result->exam->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($result->exam->end_date)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $result->score }}</td>
                <td>{{ $result->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>