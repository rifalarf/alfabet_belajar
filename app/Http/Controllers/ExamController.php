<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function create()
    {
        return view('exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $exam = new Exam();
        $exam->user_id = Auth::id();
        $exam->title = $request->title;
        $exam->start_date = $request->start_date;
        $exam->end_date = $request->end_date;
        $exam->status = 'active'; 
        $exam->save();

        return redirect()->route('dashboard')->with('success', 'Ulangan baru berhasil dibuat dan langsung aktif!');
    }
}
