<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\file;
use App\Models\studentFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\program;
use Illuminate\Support\Facades\DB;

class fileController extends Controller
{
    public function index()
    {
        $currentUserProgram = Auth::user()->programID;
        $currentProgramCourseListID = DB::table('programs')->where('programID',$currentUserProgram)->value('courseListID');
        $listOfCoursesForCourseListID = DB::table('course_lists')->where('courseListID',$currentProgramCourseListID)->get();
        $files = File::all();

        return view('students/main', [
            'documents' => $files,
            'courseList' => $listOfCoursesForCourseListID,
        ]);
    }

    public function show()
    {
        $files = File::all();

        return view('students/main', [
            'documents' => $files,
        ]);
    }

    public function destroy($id)
    {
        $doc = File::where('fileID', $id)->delete();
        

        return redirect()->route('document');
    }

    public function update(Request $request)
    {
        $request->validate([
            'file' => 'mimes:jpeg,bmp,png,pdf,jpg,docx,txt',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs('PDF', $_FILES['file']['name']);
            $realPath = storage_path()."\\app\\".str_replace('/','\\',$path);
            $pdf = new Pdf($realPath);
            $num = $pdf->getNumberOfPages();
            $imageData = $pdf->saveImage('image');
            $base64Img = base64_encode($imageData);
            $ext = $request->file->extension();
            $doc = file_get_contents($realPath);
            $base64 = base64_encode($doc);
            $mime = $request->file('file')->getClientMimeType();

            $createFile = File::create([
                'fileName' => $_FILES['file']['name'],
                'fileType' => $ext,
                'mime' => $mime,
                'noPage' => $num,   
                'dateUpload' => Carbon::now(),
                'file' => $base64,
                'thumbnail' => $base64Img,
            ]);

            $fileID = $createFile->id;
            $studentID =  $request->input('studentID');

            StudentFile::create([
                'fileID' => $fileID,
                'studentID' => $studentID,
            ]);
            
            return redirect()->route('document');
        }
    }

    public function download($id)
    {
        $document = File::where('fileID', $id)->first();

        $file_contents = base64_decode($document->file);

        return response($file_contents)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $document->mime)
            ->header('Content-length', strlen($file_contents))
            ->header('Content-Disposition', 'attachment; filename=' . $document->fileName)
            ->header('Content-Transfer-Encoding', 'binary');
    }
}
