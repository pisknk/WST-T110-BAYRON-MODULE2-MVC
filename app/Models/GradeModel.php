<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeModel extends Model
{
    use HasFactory;

    protected $table = 'grades';
    protected $fillable = ['student_id', 'subject_code', 'grade'];

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id', 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_code', 'subject_code');
    }
}
