<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'reportID',
        'orderID',
    ];
}
