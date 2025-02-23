<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'student_subject', 'subject_id', 'student_id');
    }

}
