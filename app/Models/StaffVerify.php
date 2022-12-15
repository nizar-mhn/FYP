<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffVerify extends Model
{
    use HasFactory;

    public $table = "staff_verifies";

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
