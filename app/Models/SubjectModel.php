<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'subject_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['subject_code', 'name'];

    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'student_subject', 'subject_code', 'student_id', 'subject_code', 'student_id');
    }

}
