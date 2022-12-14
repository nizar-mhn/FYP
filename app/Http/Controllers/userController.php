<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Supplier;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Course;
use App\Models\Program;
use App\Models\ProgramDetails;
use App\Models\CourseList;


class userController extends Controller
{

    public function create()
    {
        $user = new user;
        $user->createCourse();
        $user->createCourseList();
        $user->createProg();
        $user->createProgDetails();
        $user->createAdmin();
        $user->createStaff();
        $user->createStudent();
        $user->createSupplier();
    }

    public function index()
    {
        return view('auth.register');
    }

    public function selectUser(Request $request)
    {
        if ($request->input('user') != null) {
            $this->data['programs'] = Program::all();
            return view('auth.register', $this->data)->with('user', $request->input('user'));
        }
    }

    public function createUser(Request $request)
    {
        if ($request->input('user') == "student") {

            $this->data['error'] = "";

            $userID = $request->input('studentID');
            $name = $request->input('name');
            $email = $request->input('email');
            $program = $request->input('progName');
            $year = $request->input('year');
            $sem = $request->input('sem');
            $group = $request->input('group');
            $password = $request->input('password');
            $confirmPassword = $request->input('confirmPassword');




            // Student::create([
            //     'studentID' => '2105086',
            //     'programID' => 1,
            //     'year' => 3,
            //     'semester' => 2,
            //     'group' => 7,
            //     'studentName' => 'Chan Owen',
            //     'password' => Hash::make('owenowen'),
            //     'email' => 'chan',
            // ]);
        } elseif ($request->input('user') == "lecturer") {
            dd('234');
        } else {
        }

        //return view('auth.register');
    }
}

class user
{
    public function createAdmin()
    {
        return Admin::create([
            'adminID' => 'a1111',
            'adminName' => 'Super Admin',
            'password' => Hash::make('admin'),
        ]);
    }

    public function createSupplier()
    {
        Supplier::create([
            'supplierID' => 's1111',
            'supplierName' => 'Lai Man Wai',
            'password' => Hash::make('manwai'),
        ]);

        return Supplier::create([
            'supplierID' => 's2222',
            'supplierName' => 'Thomas San',
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
            'email' => 'chan',

        ]);

        Staff::create([
            'staffID' => 'p2222',
            'courseListID' => 1,
            'staffName' => 'Goh Shu Hang',
            'password' => Hash::make('shuhang'),
            'email' => 'chan',

        ]);

        return Staff::create([
            'staffID' => 'p3333',
            'courseListID' => 2,
            'staffName' => 'Chew Shen Heng',
            'password' => Hash::make('shenheng'),
            'email' => 'chan',

        ]);
    }

    public function createStudent()
    {
        Student::create([
            'studentID' => '2105086',
            'studentName' => 'Chan Owen',
            'password' => Hash::make('owenowen'),
            'email' => 'chan',
            'programDetailsID' => 1,
        ]);

        Student::create([
            'studentID' => '2105179',
            'studentName' => 'Nizar Bin Hamid',
            'password' => Hash::make('owenowen'),
            'email' => 'chan',
            'programDetailsID' => 2,
        ]);

        return Student::create([
            'studentID' => '1904338',
            'studentName' => 'Micheal Owen',
            'password' => Hash::make('owenowen'),
            'email' => 'chan',
            'programDetailsID' => 3,
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

        Course::create([
            'courseName' => 'Research Methods',
            'courseCode' => 'BACS2042',
        ]);

        Course::create([
            'courseName' => 'Human Computer Interaction',
            'courseCode' => 'BAIT2203',
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

        CourseList::create([
            'courseListID' => 2,
            'courseID' => 5,
        ]);

        CourseList::create([
            'courseListID' => 3,
            'courseID' => 2,
        ]);

        CourseList::create([
            'courseListID' => 3,
            'courseID' => 6,
        ]);

        CourseList::create([
            'courseListID' => 4,
            'courseID' => 7,
        ]);

        CourseList::create([
            'courseListID' => 5,
            'courseID' => 2,
        ]);

        CourseList::create([
            'courseListID' => 5,
            'courseID' => 5,
        ]);

        CourseList::create([
            'courseListID' => 6,
            'courseID' => 1,
        ]);

        return CourseList::create([
            'courseListID' => 6,
            'courseID' => 4,
        ]);
    }

    public function createProg()
    {
        Program::create([
            'programName' => 'RSD - Bachelor of Information Technology (Honours) in Software Systems Development',
        ]);

        return Program::create([
            'programName' => 'DFT - Diploma in Information Technology',
        ]);
    }

    public function createProgDetails()
    {
        ProgramDetails::create([
            'programID' => 1,
            'year' => 1,
            'semester' => 1,
            'courseListID' => 1,
        ]);

        ProgramDetails::create([
            'programID' => 1,
            'year' => 1,
            'semester' => 2,
            'courseListID' => 2,
        ]);

        ProgramDetails::create([
            'programID' => 1,
            'year' => 1,
            'semester' => 3,
            'courseListID' => 3,
        ]);

        ProgramDetails::create([
            'programID' => 1,
            'year' => 2,
            'semester' => 1,
            'courseListID' => 4,
        ]);

        ProgramDetails::create([
            'programID' => 1,
            'year' => 2,
            'semester' => 2,
            'courseListID' => 5,
        ]);

        ProgramDetails::create([
            'programID' => 1,
            'year' => 2,
            'semester' => 3,
            'courseListID' => 6,
        ]);
    }
}
