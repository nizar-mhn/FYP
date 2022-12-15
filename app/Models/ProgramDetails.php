<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'programDetailsID';
    public $timestamps = false;

    protected $fillable = [
        'programDetailsID',
        'programID',
        'year',
        'semester',
        'courseListID',
    ];
}
