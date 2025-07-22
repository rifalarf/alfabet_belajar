<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\PracticeResult;


class LatihanController extends Controller
{

    public function index()
    {
        $levels = Level::all();
        return view('latihan.index', ['levels' => $levels]);
    }

    public function show(Level $level)
    {

        $questions = $level->questions()->with(['correctAnswer', 'options.alphabet'])->inRandomOrder()->get();

        return view('latihan.show', [
            'level' => $level,
            'questions' => $questions
        ]);
    }
    public function storeResult(Request $request)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'total_questions' => 'required|integer',
            'correct_answers' => 'required|integer',
        ]);

        $score = ($validated['correct_answers'] / $validated['total_questions']) * 100;

        $result = new PracticeResult();
        $result->level_id = $validated['level_id'];
        $result->total_questions = $validated['total_questions'];
        $result->correct_answers = $validated['correct_answers'];
        $result->score = round($score);
        if (auth()->check()) {
            $result->user_id = auth()->id();
        }
        $result->save();

        return response()->json(['result_id' => $result->id]);
    }

   
    public function showResult(PracticeResult $result)
    {
        return view('latihan.result', ['result' => $result]);
    }
}
