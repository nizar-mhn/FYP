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

        //return redirect()->route('document');
    }

    
}

class user{
    public function createAdmin()
    {
        Admin::create([
            'adminID' => 's1111',
            'adminName' => 'Lai Man Wai',
            'password' => Hash::make('manwai'),
        ]);

        return Admin::create([
            'adminID' => 's2222',
            'adminName' => 'Thomas San',
            'password' => Hash::make('thomas'),
            
        ]);
    }

    public function createStaff()
    {
        Staff::create([
            'staffID' => 'p1111',
            'courseListID' => 1,
            'staffName' => 'Ho Wai Kit',
            'password' => Hash::make('waikit'),
            
        ]);

        Staff::create([
            'staffID' => 'p2222',
            'courseListID' => 1,
            'staffName' => 'Goh Shu Hang',
            'password' => Hash::make('shuhang'),
            
        ]);

        return Staff::create([
            'staffID' => 'p3333',
            'courseListID' => 2,
            'staffName' => 'Chew Shen Heng',
            'password' => Hash::make('shenheng'),
            
        ]);
    }

    public function createStudent()
    {
        Student::create([
            'studentID' => '2105086',
            'programID' => 1,
            'year' => 3,
            'semester' => 2,
            'group' => 7,
            'studentName' => 'Chan Owen',
            'password' => Hash::make('owenowen'),
        ]);

        Student::create([
            'studentID' => '2105179',
            'programID' => 1,
            'year' => 3,
            'semester' => 2,
            'group' => 7,
            'studentName' => 'Nizar Bin Hamid',
            'password' => Hash::make('owenowen'),
        ]);

        return Student::create([
            'studentID' => '1904338',
            'programID' => 2,
            'year' => 1,
            'semester' => 3,
            'group' => 2,
            'studentName' => 'Micheal Owen',
            'password' => Hash::make('owenowen'),
        ]);
    }

    public function createCourse()
    {
        Course::create([
            'courseName' => 'Software Engineering',
            'courseCode' => 'BACS2163',
        ]);

        Course::create([
            'courseName' => 'Computer Networks',
            'courseCode' => 'BMIT2164',
        ]);

        Course::create([
            'courseName' => 'Advance Computer Networks',
            'courseCode' => 'BMIT3094',
        ]);

        Course::create([
            'courseName' => 'Systems Analysis And Design',
            'courseCode' => 'AACS1304',
        ]);

        return Course::create([
            'courseName' => 'Operating Systems',
            'courseCode' => 'AACS2284',
        ]);
    }

    public function createCourseList()
    {

        CourseList::create([
            'courseListID' => 1,
            'courseID' => 1,
        ]);

        CourseList::create([
            'courseListID' => 1,
            'courseID' => 2,
        ]);

        CourseList::create([
            'courseListID' => 1,
            'courseID' => 3,
        ]);

        CourseList::create([
            'courseListID' => 2,
            'courseID' => 4,
        ]);

        return CourseList::create([
            'courseListID' => 2,
            'courseID' => 5,
        ]);
    }

    public function createProg()
    {
        Program::create([
            'courseListID' => 1,
            'programName' => 'RSD - Bachelor of Information Technology (Honours) in Software Systems Development',
        ]);

        return Program::create([
            'courseListID' => 2,
            'programName' => 'DFT - Diploma in Information Technology',
        ]);
    }
}
