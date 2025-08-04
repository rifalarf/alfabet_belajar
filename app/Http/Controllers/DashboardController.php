<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamResult::with('exam')->whereHas('exam', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest();

        if ($request->filled('due_date')) {
            $query->whereHas('exam', function ($q) use ($request) {
                $q->where('user_id', Auth::id())
                    ->where('start_date', '<=', $request->due_date)
                    ->where('end_date', '>=', $request->due_date);
            });
        }

        // Filter berdasarkan judul ulangan kudunamah
        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        $examResults = $query->get();
        $exams = Exam::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', [
            'examResults' => $examResults,
            'exams' => $exams
        ]);
    }

    public function destroyResult(ExamResult $result)
    {
        $result->delete();
        return redirect()->route('dashboard')->with('success', 'Data hasil ulangan berhasil dihapus.');
    }

    public function showResultDetail(ExamResult $result)
    {
        $result->load('exam');
        return view('dashboard.result-detail', ['result' => $result]);
    }

    public function exportResultsPdf(Request $request)
    {
        $dueDate = $request->input('due_date');
        $examId = $request->input('exam_id');
        $query = ExamResult::with('exam')->whereHas('exam', function ($q) {
            $q->where('user_id', Auth::id());
        });
        
        if ($dueDate) {
            $query->whereHas('exam', function ($q) use ($dueDate) {
                $q->where('user_id', Auth::id())
                    ->where('start_date', '<=', $dueDate)
                    ->where('end_date', '>=', $dueDate);
            });
        }

        // Filter berdasarkan judul ulangan
        if ($examId) {
            $query->where('exam_id', $examId);
        }
        
        $results = $query->get();

        $pdf = Pdf::loadView('exports.exam_results_pdf', compact('results'));
        return $pdf->download('hasil-ulangan.pdf');
    }
    public function destroyExam(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('dashboard')->with('success', 'Sesi ulangan berhasil dihapus.');
    }
}
