<?php

namespace App\Http\Controllers;
use App\Models\StudentModel;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('enrollment.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'year_level' => 'required|integer',
            'semester' => 'required|integer',
        ]);

        StudentModel::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'year_level' => $request->year_level,
            'semester' => $request->semester,
        ]);

        return redirect()->back()->with('success', 'Student enrolled successfully.');
}
}