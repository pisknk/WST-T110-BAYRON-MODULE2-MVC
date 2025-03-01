<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeModel as Grade;
use App\Models\StudentModel as Student;
use App\Models\SubjectModel as Subject;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    // Display the student's grades
    public function index($student_id)
    {
        // Get student info
        $student = Student::where('student_id', $student_id)->firstOrFail();
        
        // Get subjects the student is enrolled in with grades (if any)
        $subjects = $student->subjects()->with(['grades' => function ($query) use ($student_id) {
            $query->where('student_id', $student_id);
        }])->get();

        // Collect grades from the subjects
        $grades = $subjects->flatMap(function ($subject) {
            return $subject->grades;
        });

        // Load the view with student, subjects, and grades
        return view('grade.index', compact('student', 'subjects', 'grades'));
    }

    // Store or update a student's grade
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required',
            'subject_code' => 'required',
            'grade' => 'required|numeric|min:0|max:5',
        ]);

        try {
            DB::beginTransaction();

            Grade::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'subject_code' => $validated['subject_code'],
                ],
                [
                    'grade' => $validated['grade'],
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Grade saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Grade saving error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving grade: ' . $e->getMessage()
            ], 500);
        }
    }
}
