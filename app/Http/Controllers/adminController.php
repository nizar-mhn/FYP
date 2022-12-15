<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\ProgramDetails;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Course;
use App\Models\CourseList;

class adminController extends Controller
{
    public function index()
    { 
        $programList = Program::all();
        return view('admin.admin_main')->with('programList',$programList);
    }


    public function course()
    { 
        return view('admin.admin_course');
    }


    public function addProgram(Request $request){
        $programName =$request->input('programName');
        $year =3;
        $sem =3;
        $error = false;
        $errorMsg = "";
        $programList = Program::all();
        if(count($programList)){
            foreach($programList as $program){
                if($program->programName==$programName){
                    $error = true;
                    $errorMsg = "Duplicate program name found.";
                }
            }
            if($error){
                return view('admin.admin_main')->with(['errorProgram'=>$errorMsg,'programList'=>$programList]);
            }else{
                $newProgram = Program::create([
                    'programName' => $programName,
                ]);
        
                for($i=1;$i<=$year;$i++){
                    for($j=1;$j<=$sem;$j++){
                        ProgramDetails::create([
                            'programID' => $newProgram->programID,
                            'year' => $i,
                            'semester' => $j,
                        ]);
                    }
                }
                $programList = Program::all();
                return view('admin.admin_main')->with('programList',$programList);
            }
        }else{
            $newProgram = Program::create([
                'programName' => $programName,
            ]);
    
            for($i=1;$i<=$year;$i++){
                for($j=1;$j<=$sem;$j++){
                    ProgramDetails::create([
                        'programID' => $newProgram->programID,
                        'year' => $i,
                        'semester' => $j,
                    ]);
                }
            }
            $programList = Program::all();
            return view('admin.admin_main')->with('programList',$programList);
        }
        
        
    }


    public function addCourse(Request $request){
        $courseName ="";
        $courseCode ="";

        Course::create([
            'courseName' => $courseName,
            'courseCode' => $courseCode,
        ]);
        
    }

    public function addProgramCourseList(Request $request){
        $programID = $request->input('programID');
        $programYear = $request->input('programYear');
        $programSem = $request->input('programSem');
        $courseListID = $request->input('courseListID');
        $courseID = $request->input('courseID');
        $error = false;
        $msg = "";

        if($courseListID!=null){
            $currentCourseList = CourseList::where('courseListID', $courseListID)->get();
            foreach($currentCourseList as $courseList){
                if($courseID == $courseList->courseID){
                    $error = true;
                    $msg = "Duplicate Course";
                }
            }

            if($error){
                $courseListID = "";
                $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
                if($currentProgramDetails){
                    $courseListID =$currentProgramDetails->courseListID;
                }
                $programList = Program::all();
                return view('admin.admin_main')->with(['errorMsg'=>$msg,'programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);

            }else{
                CourseList::create([
                    'courseListID' => $courseListID,
                    'courseID' => $courseID,
                ]);
                $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
                $currentProgramDetails->courseListID = $courseListID;
                $currentProgramDetails->save();

                $courseListID = "";

                if($currentProgramDetails){
                    $courseListID =$currentProgramDetails->courseListID;
                }
                $programList = Program::all();
                return view('admin.admin_main')->with(['programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);

            }
            
        }else{
            $courseList = CourseList::orderby('courseListID', 'DESC')->first();
            if($courseList!=null){
                $courseListID = $courseList->courseListID + 1;
            }else{
                $courseListID = 1;
            }
    
            CourseList::create([
                'courseListID' => $courseListID,
                'courseID' => $courseID,
            ]);

            $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
            $currentProgramDetails->courseListID = $courseListID;
            $currentProgramDetails->save();

            $courseListID = "";

            if($currentProgramDetails){
                $courseListID =$currentProgramDetails->courseListID;
            }
            $programList = Program::all();
            return view('admin.admin_main')->with(['programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);


        }


    }

    public function deleteProgramCourseList(Request $request){
        $programID = $request->input('programID');
        $programYear = $request->input('programYear');
        $programSem = $request->input('programSem');
        $courseListID = $request->input('courseListID');
        $courseID = $request->input('courseID');

        $currentCourseList = CourseList::where('courseListID', $courseListID)->get();
        if(count($currentCourseList)==1){
            $deleted = DB::table('course_lists')->where('courseListID',$courseListID)->where('courseID',$courseID)->delete();

            $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
            $currentProgramDetails->courseListID = null;
            $currentProgramDetails->save();

            $courseListID = "";

            if($currentProgramDetails){
                $courseListID =$currentProgramDetails->courseListID;
            }
            $programList = Program::all();
            return view('admin.admin_main')->with(['programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);

        }else{
            $deleted = DB::table('course_lists')->where('courseListID',$courseListID)->where('courseID',$courseID)->delete();

            $courseListID = "";

            $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
            if($currentProgramDetails){
                $courseListID =$currentProgramDetails->courseListID;
            }
            $programList = Program::all();
            return view('admin.admin_main')->with(['programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);

        }

    }

    public function getCourseList(Request $request){
        $programID = $request->input('programID');
        $programYear = $request->input('programYear');
        $programSem = $request->input('programSem');
        $courseListID = "";
        $currentProgramDetails = ProgramDetails::where('programID', $programID)->where('year',$programYear)->where('semester',$programSem)->first();
        if($currentProgramDetails){
            $courseListID =$currentProgramDetails->courseListID;
        }
        
        $programList = Program::all();
        return view('admin.admin_main')->with(['programList'=> $programList,'courseListID'=>$courseListID,'programID'=>$programID,'programYear'=>$programYear,'programSem'=>$programSem]);
    }

    
    
}
