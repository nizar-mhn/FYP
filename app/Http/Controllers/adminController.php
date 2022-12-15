<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.admin_main');
    }

    public function addProgram(Request $request){
        $programName ="";
        $year ="";
        $sem ="";
        $courseListID ="";

        $newProgram = Program::create([
            'programName' => $programName,
        ]);

        for($i=1;$i>$year;$i++){
            for($j=1;$i>$sem;$j++){
                ProgramDetails::create([
                    'programID' => $newProgram->programID,
                    'year' => $i,
                    'semester' => $j,
                ]);
            }
        }
    }

    public function addProgramCourseList(Request $request){
        $programID = "";
        $currentProgramDetails = ProgramDetails::where('programID', $programID)->first();
        $courseList = CourseList::orderby('courseListID', 'DESC')->first();
        $courseListID = $courseList->courseListID + 1;

        foreach ($this->data['course'] as $courses) {
            CourseList::create([
                'courseListID' => $courseListID,
                'courseID' => $courses,
            ]);
        }

        $currentProgramDetails->courseListID = $courseListID;
        $currentProgramDetails->save();

    }

    public function editProgram(Request $request){
        
        $programID = "";
        $programName ="";
        $year ="";
        $sem ="";
        $courseListID ="";

        $currentProgram = Program::where('programID', $programID)->first();
        $currentProgram->programName = $programName;
        $currentProgram->save();

        $currentProgramDetails = ProgramDetails::where('programID', $programID)->first();
        $currentProgram->year = $year;
        $currentProgram->sem = $sem;
        $currentProgram->courseListID = $courseListID;
        $currentProgram->save();

        
    }

    public function addCourse(Request $request){
        $courseName ="";
        $courseCode ="";

        Course::create([
            'courseName' => $courseNam,
            'courseCode' => $courseCode,
        ]);
        
    }

    public function addCourseList(Request $request){

        $courseList = CourseList::orderby('courseListID', 'DESC')->first();
        $courseListID = $courseList->courseListID + 1;

        foreach ($this->data['course'] as $courses) {
            CourseList::create([
                'courseListID' => $courseListID,
                'courseID' => $courses,
            ]);
        }

    }

    
    
}
