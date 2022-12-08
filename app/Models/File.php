<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'fileName',
        'fileType',
        'mime',
        'noPage',
        'dateUpload',
        'thumbnail',
        'file',
    
    ];
}
