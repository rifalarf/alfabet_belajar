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
        $query = ExamResult::with('exam')->latest();

        if ($request->filled('due_date')) {
            $query->whereHas('exam', function ($q) use ($request) {
                $q->where('start_date', '<=', $request->due_date)
                    ->where('end_date', '>=', $request->due_date);
            });
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
        $query = ExamResult::with('exam');
        if ($dueDate) {
            $query->whereHas('exam', function ($q) use ($dueDate) {
                $q->where('start_date', '<=', $dueDate)
                    ->where('end_date', '>=', $dueDate);
            });
        }
        $results = $query->get();

        $pdf = Pdf::loadView('exports.exam_results_pdf', compact('results'));
        return $pdf->download('hasil-ulangan.pdf');
    }
}
