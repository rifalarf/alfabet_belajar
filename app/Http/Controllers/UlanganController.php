<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UlanganController extends Controller
{
    /**
     * Menampilkan daftar ulangan yang aktif.
     */
    public function index()
    {
        $today = now()->toDateString();
        $activeExams = Exam::with('user')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();
        return view('ulangan.index', ['activeExams' => $activeExams]);
    }

    /**
     * Menampilkan halaman "Cek Wajah".
     */
    public function showFaceCheck(Exam $exam)
    {
        return view('ulangan.face-check', ['exam' => $exam]);
    }

    /**
     * Membuat record hasil dan menyimpan foto wajah yang diunggah dari kamera.
     */
    public function storeFaceImage(Request $request, Exam $exam)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $examResult = ExamResult::create([
            'exam_id' => $exam->id,
            'student_name' => 'Siswa',
            'score' => 0,
        ]);

        try {
            $filePath = $request->file('image')->getRealPath();

            // PERBAIKAN: Pastikan kita mendapatkan URL lengkap
            $uploadedFileUrl = Cloudinary::upload($filePath, [
                'folder' => 'face_images'
            ])->getSecurePath();

            // Simpan URL LENGKAP ke database
            $examResult->face_image_path = $uploadedFileUrl;
            $examResult->save();

        } catch (\Exception $e) {
            $examResult->delete();
            Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Upload ke Cloudinary gagal.'], 500);
        }

        return response()->json([
            'success' => true,
            'redirect_url' => route('ulangan.soal', ['exam_result' => $examResult->id])
        ]);
    }

    /**
     * Menampilkan halaman soal untuk ulangan yang sedang berlangsung.
     */
    public function showSoal(ExamResult $exam_result)
    {
        $questions = Question::with(['correctAnswer', 'options.alphabet'])
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('ulangan.soal', [
            'examResult' => $exam_result,
            'questions' => $questions
        ]);
    }

    /**
     * Menyimpan hasil ulangan ke database.
     */
    public function storeResult(Request $request)
    {
        $validated = $request->validate([
            'exam_result_id' => 'required|exists:exam_results,id',
            'correct_answers' => 'required|integer',
            'total_questions' => 'required|integer',
        ]);

        $examResult = ExamResult::findOrFail($validated['exam_result_id']);
        $score = ($validated['total_questions'] > 0) ? (($validated['correct_answers'] / $validated['total_questions']) * 100) : 0;

        // Update catatan hasil ulangan dengan skor dan jumlah jawaban
        $examResult->score = round($score);
        $examResult->correct_answers = $validated['correct_answers'];
        $examResult->total_questions = $validated['total_questions'];
        $examResult->save();

        return response()->json(['result_id' => $examResult->id]);
    }

    /**
     * Menampilkan halaman hasil ulangan.
     */
    public function showResult(ExamResult $exam_result)
    {
        return view('ulangan.result', ['examResult' => $exam_result]);
    }
}
