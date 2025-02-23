<?php

namespace App\Http\Controllers;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::all(); // fetch subjects
        return view('enrollment.index', compact('subjects')); // pass subjects to the view
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'year_level' => 'required',
        'semester' => 'required',
        'subjects' => 'required|array',
    ]);

    // Create or find the student
    $student = StudentModel::updateOrCreate(
        ['student_id' => $validated['student_id']],
        [
            'first_name' => $validated['first_name'],
            'middle_name' => $request->middle_name,
            'last_name' => $validated['last_name'],
            'year_level' => $validated['year_level'],
            'semester' => $validated['semester'],
        ]
    );

    // Attach subjects using subject_code, not id
    $student->subjects()->sync($validated['subjects']);

    return redirect()->back()->with('success', 'YEY!! Student enrolled successfully :3');
}
}
