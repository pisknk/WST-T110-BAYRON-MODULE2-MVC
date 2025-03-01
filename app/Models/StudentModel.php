<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'year_level',
        'semester',
    ];

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'student_subject', 'student_id', 'subject_code');
    }

}
