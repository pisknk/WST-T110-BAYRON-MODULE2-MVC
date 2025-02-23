<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\SubjectModel;

class StudentController extends Controller
{

    public function index()
    {
        $students = StudentModel::all();
        return view('student.index', compact('students'));
    }

    public function edit($student_id)
    {
        $student = StudentModel::findOrFail($student_id);
        $subjects = SubjectModel::all();
        return view('editStudent.index', compact('student', 'subjects'));
    }
}
