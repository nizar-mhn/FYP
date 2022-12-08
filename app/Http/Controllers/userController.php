<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Course;
use App\Models\Program;
use App\Models\CourseList;


class userController extends Controller
{

    public function index()
    {
        $user = new user;
        $user->createCourse();
        $user->createCourseList();
        $user->createProg();
        $user->createAdmin();
        $user->createStaff();
        $user->createStudent();

        return redirect()->route('document');
    }

    
}

class user{
    public function createAdmin()
    {
        return Admin::create([
            'adminID' => 'p1234',
            'adminName' => 'Man Wai',
            'password' => Hash::make('manwai123'),
        ]);
    }

    public function createStaff()
    {
        return Staff::create([
            'staffID' => 's1234',
            'courseListID' => 1,
            'staffName' => 'Wai Kit',
            'password' => Hash::make('waikit123'),
            
        ]);
    }

    public function createStudent()
    {
        return Student::create([
            'studentID' => '2105086',
            'programID' => 1,
            'year' => 3,
            'semester' => 2,
            'group' => 7,
            'studentName' => 'Owen',
            'password' => Hash::make('owenowen'),
        ]);
    }

    public function createCourse()
    {
        return Course::create([
            'courseID' => 1,
            'courseName' => 'ACN',
            'courseCode' => 'BMIT1234',
        ]);
    }

    public function createCourseList()
    {
        return CourseList::create([
            'courseListID' => 1,
            'courseID' => 1,
        ]);
    }

    public function createProg()
    {
        return Program::create([
            'programID' => 1,
            'courseListID' => 1,
            'programName' => 'RSD',
        ]);
    }
}
