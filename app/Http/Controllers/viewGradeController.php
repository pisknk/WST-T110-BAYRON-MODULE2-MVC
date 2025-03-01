<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel as Student;
use App\Models\SubjectModel as Subject;
use App\Models\GradeModel as Grade;
use Illuminate\Support\Facades\Auth;

class ViewGradeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        try {
            // For students, get their ID from their email
            if ($user->role === 'student') {
                $email = $user->email;
                $studentId = substr($email, 0, strpos($email, '@'));
            } else {
                // For admin, get student ID from request or show error
                $studentId = $request->input('student_id');
                if (!$studentId) {
                    return redirect()->back()->with('error', 'Please specify a student ID');
                }
            }

            // Find the student
            $student = Student::where('student_id', $studentId)->first();
            
            if (!$student) {
                return back()->with('error', 'Student not found. Please check the student ID.');
            }

            // Get all subjects with their grades for this student
            $subjects = Subject::with(['grades' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])->get();

            // Return the view with the data
            return view('viewGrade.index', compact('student', 'subjects'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to find student records. Please ensure the student ID is correct.');
        }
    }
}
