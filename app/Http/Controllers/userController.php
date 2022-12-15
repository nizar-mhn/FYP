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
use App\Models\StudentVerify;
use App\Models\StaffVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class userController extends Controller
{

    public function create()
    {
        $user = new user;
        $user->createCourse();
        $user->createAdmin();
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
            } else if (count($studentEmail) || count($staffEmail)) {
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
            } else {
                $programDetailsID = ProgramDetails::where('programID', '=', $this->data['prog'])->where('year', '=', $this->data['year'])->where('semester', '=', $this->data['sem'])->first();

                $newUser = Student::create([
                    'studentID' => $this->data['userID'],
                    'studentName' => $this->data['name'],
                    'password' => Hash::make($this->data['password']),
                    'email' => $this->data['email'],
                    'programDetailsID' => $programDetailsID->programDetailsID,
                ]);

                $token = Str::random(64);

                StudentVerify::create([
                    'user_id' => $newUser->id,
                    'token' => $token
                ]);

                Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
                    $message->to($this->data['email']);
                    $message->subject('Email Verification Mail');
                });


                return redirect()->route('login')->with('info', 'You have register successfully. Please check your email to verify your Account.');
            }
        } elseif ($request->input('user') == "Staff") {
            $error = false;
            $this->data['userID'] = $request->input('staffID');
            $this->data['name'] = $request->input('name');
            $this->data['email'] = $request->input('email');
            $this->data['course'] = $request->input('course');
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
            } else if (count($staffEmail) || count($studentEmail)) {
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
                $newUser = Staff::create([
                    'staffID' => $this->data['userID'],
                    'staffName' => $this->data['name'],
                    'password' => Hash::make($this->data['password']),
                    'email' => $this->data['email'],
                    'courseListID' => $courseListID,
                ]);

                $token = Str::random(64);

                StaffVerify::create([
                    'user_id' => $newUser->id,
                    'token' => $token
                ]);

                Mail::send('email.emailVerificationEmailStaff', ['token' => $token], function ($message) use ($request) {
                    $message->to($this->data['email']);
                    $message->subject('Email Verification Mail');
                });


                return redirect()->route('login')->with('info', 'You have register successfully. Please check your email to verify your Account.');
            }
        } else {
        }
    }


    public function verifyStudentAccount($token)
    {
        $verifyUser = StudentVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = Student::where('id', $verifyUser->user_id)->first();

            if (!$user->is_email_verified) {
                $user->is_email_verified = 1;
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login')->with('info', $message);
    }

    public function verifyStaffAccount($token)
    {
        $verifyUser = StaffVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = Staff::where('id', $verifyUser->user_id)->first();

            if (!$user->is_email_verified) {
                $user->is_email_verified = 1;
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login')->with('info', $message);
    }

    public function forgotPassword()
    {
        return view('auth.passwords.email');
    }

    public function resetPassword(Request $request)
    {
        $error = false;
        $user = "";
        $this->data['email'] = $request->input('email');

        //email
        $studentEmail = DB::table('students')->where('email', '=', $this->data['email'])->first();
        $staffEmail = DB::table('staff')->where('email', '=', $this->data['email'])->first();

        if ($this->data['email'] == null) {
            $this->data['errorEmail'] = "Please enter your Email";
            $error = true;
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->data['errorEmail'] = "Email Must be a valid email address.";
            $error = true;
        } else if ($staffEmail == null && $studentEmail == null) {
            $this->data['errorEmail'] = "This email address has not been registered.";
            $error = true;
        } else if ($staffEmail != null) {
            $user = "Staff";

            if (!$staffEmail->is_email_verified) {
                $this->data['errorEmail'] = "This email address has not been verified. Please check your email to verify your account first.";
                $error = true;
            }
        } else if ($studentEmail != null) {
            $user = "Student";
            if (!$studentEmail->is_email_verified) {
                $this->data['errorEmail'] = "This email address has not been verified. Please check your email to verify your account first.";
                $error = true;
            }
        }


        if ($error) {
            return view('auth.passwords.email', $this->data);
        } else {

            $token = Str::random(64);

            Mail::send('email.passwordResetEmail', ['token' => $token, 'email' => $this->data['email'], 'user' => $user], function ($message) use ($request) {
                $message->to($this->data['email']);
                $message->subject('Email Verification Mail');
            });


            return redirect()->route('login')->with('info', 'Please check your email to reset your password.');
        }
    }

    public function confirmEmail($token, $email, $user)
    {
        return view('auth.passwords.reset', [$token, 'email' => $email, 'user' => $user]);
    }

    public function passwordReset(Request $request)
    {

        $error = false;
        $user = $request->input('user');
        $email = $request->input('email');

        $this->data['password'] = $request->input('password');
        $this->data['confirmPassword'] = $request->input('confirmPassword');

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

        if (!$error) {
            if ($user == "Staff") {
                $staff = Staff::where('email', $email)->first();
                if (Hash::check($this->data['password'], $staff->password)) {
                    $this->data['errorPassword'] = "New password cannot same as Old password.";
                    return view('auth.passwords.reset', ['email' => $email, 'user' => $user])->with($this->data);
                } else {
                    $staff->password = Hash::make($this->data['password']);
                    $staff->save();
                    return redirect()->route('login')->with('info', 'Your password has been reset, you may try to login.');
                }
            } else {
                $student = Student::where('email', $email)->first();
                if (Hash::check($this->data['password'], $student->password)) {
                    $this->data['errorPassword'] = "New password cannot same as Old password.";
                    return view('auth.passwords.reset', ['email' => $email, 'user' => $user])->with($this->data);
                } else {
                    $student->password = Hash::make($this->data['password']);
                    $student->save();
                    return redirect()->route('login')->with('info', 'Your password has been reset, you may try to login.');
                }
            }
        } else {
            return view('auth.passwords.reset', ['email' => $email, 'user' => $user])->with($this->data);
        }
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
}
