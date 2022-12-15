<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentVerify extends Model
{
    use HasFactory;

    public $table = "student_verifies";

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
