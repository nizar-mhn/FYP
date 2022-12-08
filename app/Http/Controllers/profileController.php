<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $program = Program::where('programID', $user->programID)->first();

        return view('students/profile', [
            'program' => $program,
        ]);
    }
}
