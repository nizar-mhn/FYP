<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class staffController extends Controller
{
    public function index()
    {
        return view('staff/staff_main');
    }

    public function setAvailability(Request $request){
        $fileID = $request->input('fileID');
        $availability = $request->input('availability');
        $currentFile = File::where('fileID', $fileID)->first();
        if($availability){
            $currentFile->availability = "Not Available";
            $currentFile->save();
        }else{
            $currentFile->availability = "Available";
            $currentFile->save();
        }
        return view('/staff/fileInfo')->with('fileID', $fileID);
    }
}
