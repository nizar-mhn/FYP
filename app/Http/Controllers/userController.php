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
use Illuminate\Support\Facades\DB;


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
        //$user->createStudent();
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
            $this->data['courses'] = Course::orderby('courseCode')->get();
            $this->data['user'] = $request->input('user');
            return view('auth.register', $this->data);
        }
    }

    public function selectProg(Request $request)
    {
        if ($request->input('prog') != null) {
            $this->data['user'] = $request->input('user');
            $this->data['prog'] = $request->input('prog');
            $this->data['programDetails'] = DB::table('program_details')->where('programID', '=', $request->input('prog'))->groupBy('year')->get();
            $this->data['programDetailsSem'] = DB::table('program_details')->where('programID', '=', $request->input('prog'))->groupBy('semester')->get();
            return view('auth.register', $this->data);
        }
    }

    public function validation(Request $request)
    {
        if ($request->input('user') == "Student") {


            $error = false;
            $this->data['userID'] = $request->input('studentID');
            $this->data['name'] = $request->input('name');
            $this->data['email'] = $request->input('email');
            $this->data['prog'] = $request->input('prog');
            $this->data['year'] = $request->input('year');
            $this->data['sem'] = $request->input('sem');
            $this->data['password'] = $request->input('password');
            $this->data['confirmPassword'] = $request->input('confirmPassword');

            //Name
            if ($this->data['name'] == null) {
                $this->data['errorName'] = "Please enter your Name.";
                $error = true;
            } else if (!preg_match("/^[a-zA-Z ]*$/", $this->data['name'])) {
                $this->data['errorName'] = "Only alphabets and white space are allowed";
                $error = true;
            }



            //ID
            $studentID = DB::table('students')->where('studentID', '=', $this->data['userID'])->get();
            if ($this->data['userID'] == null) {
                $this->data['errorID'] = "Please enter your Student ID.";
                $error = true;
            } else if (strlen($this->data['userID']) != 7) {
                $this->data['errorID'] = "Invalid Student ID.";
                $error = true;
            } else if (count($studentID)) {
                $this->data['errorID'] = "This Student ID has been registered.";
                $error = true;
            }


            //email
            $studentEmail = DB::table('students')->where('email', '=', $this->data['email'])->get();
            $staffEmail = DB::table('staff')->where('email', '=', $this->data['email'])->get();
            if ($this->data['email'] == null) {
                $this->data['errorEmail'] = "Please enter your Email";
                $error = true;
            } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->data['errorEmail'] = "Email Must be a valid email address.";
                $error = true;
            } else if (count($studentEmail)||count($staffEmail)) {
                $this->data['errorEmail'] = "This email address has been registered.";
                $error = true;
            }

            //password
            if ($this->data['password'] == null) {
                $this->data['errorPassword'] = "Please enter your Password.";
                $error = true;
            } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $this->data['password'])) {
                $this->data['errorPassword'] = "Minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 number.";
                $error = true;
            }
            //confirm password
            if ($this->data['confirmPassword'] == null) {
                $this->data['errorConfirmPass'] = "Please enter your Confirm Password.";
                $error = true;
            } elseif ($this->data['confirmPassword'] != $this->data['password']) {
                $this->data['errorConfirmPass'] = "Please enter the same Password for the Confirm Password.";
                $error = true;
            }


            if ($error) {
                $this->data['user'] = $request->input('user');
                $this->data['prog'] = $request->input('prog');
                $this->data['programDetails'] = DB::table('program_details')->where('programID', '=', $request->input('prog'))->groupBy('year')->get();
                $this->data['programDetailsSem'] = DB::table('program_details')->where('programID', '=', $request->input('prog'))->groupBy('semester')->get();
                return view('auth.register', $this->data);
                //return redirect()->route('selectProgram',$this->data)->with('user', $request->input('user'))->with('prog', $request->input('prog'));
                //return view('auth.register', $this->data)->with('user', $request->input('user'))->with('prog', $request->input('prog'));
            } else {
                $programDetailsID = ProgramDetails::where('programID', '=', $this->data['prog'])->where('year', '=', $this->data['year'])->where('semester', '=', $this->data['sem'])->first();

                Student::create([
                    'studentID' => $this->data['userID'],
                    'studentName' => $this->data['name'],
                    'password' => Hash::make($this->data['password']),
                    'email' => $this->data['email'],
                    'programDetailsID' => $programDetailsID->programDetailsID,
                ]);


                return redirect()->route('login')->with('info', 'You have register successfully.');
            }
        } elseif ($request->input('user') == "Staff") {
            $error = false;
            $this->data['userID'] = $request->input('staffID');
            $this->data['name'] = $request->input('name');
            $this->data['email'] = $request->input('email');
            $this->data['course'] = $request->input('course');
            //dd($this->data['course']);
            $this->data['password'] = $request->input('password');
            $this->data['confirmPassword'] = $request->input('confirmPassword');

            //Name
            if ($this->data['name'] == null) {
                $this->data['errorName'] = "Please enter your Name.";
                $error = true;
            } else if (!preg_match("/^[a-zA-Z ]*$/", $this->data['name'])) {
                $this->data['errorName'] = "Only alphabets and white space are allowed";
                $error = true;
            }

            //ID
            $staffID = DB::table('staff')->where('staffID', '=', $this->data['userID'])->get();
            if ($this->data['userID'] == null) {
                $this->data['errorID'] = "Please enter your Staff ID.";
                $error = true;
            } else if (strlen($this->data['userID']) != 5 || $this->data['userID'][0] != 'p') {
                $this->data['errorID'] = "Invalid Staff ID.";
                $error = true;
            } else if (count($staffID)) {
                $this->data['errorID'] = "This Staff ID has been registered.";
                $error = true;
            }

            //email
            $studentEmail = DB::table('students')->where('email', '=', $this->data['email'])->get();
            $staffEmail = DB::table('staff')->where('email', '=', $this->data['email'])->get();
            if ($this->data['email'] == null) {
                $this->data['errorEmail'] = "Please enter your Email";
                $error = true;
            } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->data['errorEmail'] = "Email Must be a valid email address.";
                $error = true;
            } else if (count($staffEmail)||count($studentEmail)) {
                $this->data['errorEmail'] = "This email address has been registered.";
                $error = true;
            }

            //password
            if ($this->data['password'] == null) {
                $this->data['errorPassword'] = "Please enter your Password.";
                $error = true;
            } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $this->data['password'])) {
                $this->data['errorPassword'] = "Minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 number.";
                $error = true;
            }
            //confirm password
            if ($this->data['confirmPassword'] == null) {
                $this->data['errorConfirmPass'] = "Please enter your Confirm Password.";
                $error = true;
            } elseif ($this->data['confirmPassword'] != $this->data['password']) {
                $this->data['errorConfirmPass'] = "Please enter the same Password for the Confirm Password.";
                $error = true;
            }


            if ($error) {
                $this->data['user'] = $request->input('user');
                $this->data['courses'] = Course::orderby('courseCode')->get();
                return view('auth.register', $this->data);
            } else {
                $courseList = CourseList::orderby('courseListID', 'DESC')->first();
                $courseListID = $courseList->courseListID + 1;
                //dd($courseListID->courseListID);
                foreach ($this->data['course'] as $courses) {
                    CourseList::create([
                        'courseListID' => $courseListID,
                        'courseID' => $courses,
                    ]);
                }
                Staff::create([
                    'staffID' => $this->data['userID'],
                    'staffName' => $this->data['name'],
                    'password' => Hash::make($this->data['password']),
                    'email' => $this->data['email'],
                    'courseListID' => $courseListID,
                ]);


                return redirect()->route('login')->with('info', 'You have register successfully.');
            }
        } else {
        }
    }


    public function validationStaff(Request $request)
    {


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
