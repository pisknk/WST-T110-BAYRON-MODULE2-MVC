<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::withCount('students')->get();
        return view('subject.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|unique:subjects,subject_code',
            'name' => 'required'
        ]);

        SubjectModel::create([
            'subject_code' => $request->subject_code,
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Subject added successfully');
    }

    public function update(Request $request, $subject_code)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $subject = SubjectModel::findOrFail($subject_code);
        $subject->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully');
    }

    public function destroy($subject_code)
    {
        $subject = SubjectModel::findOrFail($subject_code);
        $subject->delete();
        
        return redirect('/subject?deleted=true')->with('success', 'Subject deleted successfully');
    }
}
