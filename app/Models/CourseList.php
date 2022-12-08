<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseList extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'courseListID',
        'courseID',
    ];
}
