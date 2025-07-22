<?php


namespace App\Exports;

use App\Models\ExamResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExamResultsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDrawings
{
    protected $dueDate;
    protected $results;

    public function __construct($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    public function collection()
    {
        $query = ExamResult::with('exam');

        if ($this->dueDate) {
            $query->whereHas('exam', function ($q) {
                $q->where('start_date', '<=', $this->dueDate)
                  ->where('end_date', '>=', $this->dueDate);
            });
        }

        $this->results = $query->get();
        return $this->results;
    }

    public function headings(): array
    {
        return [
            'Foto Siswa',
            'Judul Ulangan',
            'Periode Ulangan',
            'Skor',
            'Tanggal Mengerjakan',
        ];
    }

    public function map($result): array
    {
        $periode = $result->exam ? (\Carbon\Carbon::parse($result->exam->start_date)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($result->exam->end_date)->format('d M Y')) : 'N/A';

        // Kolom pertama (Foto Siswa) akan diisi gambar oleh WithDrawings, jadi bisa kosong atau isi dengan keterangan
        return [
            '', // gambar akan diisi oleh WithDrawings
            $result->exam->title ?? 'N/A',
            $periode,
            $result->score,
            $result->created_at->format('d-m-Y H:i:s'),
        ];
    }

    public function drawings()
    {
        $drawings = [];
        // Baris pertama adalah heading, jadi gambar mulai dari baris 2
        $row = 2;

        foreach ($this->results as $result) {
            if ($result->face_image_path && file_exists(public_path('storage/' . $result->face_image_path))) {
                $drawing = new Drawing();
                $drawing->setName('Foto Siswa');
                $drawing->setDescription('Foto Siswa');
                $drawing->setPath(public_path('storage/' . $result->face_image_path));
                $drawing->setHeight(60); // Atur tinggi gambar
                $drawing->setCoordinates('A' . $row);
                $drawings[] = $drawing;
            }
            $row++;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}