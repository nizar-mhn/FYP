<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\file;
use Carbon\Carbon;

class fileController extends Controller
{
    public function index()
    {
        $files = File::all();

        return view('students/main', [
            'documents' => $files,
        ]);
    }

    public function show()
    {
        $files = File::all();

        return view('students/uploadFile', [
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
            $path = $request->file('file')->getRealPath();
            $ext = $request->file->extension();
            $doc = file_get_contents($path);
            $base64 = base64_encode($doc);
            $mime = $request->file('file')->getClientMimeType();

            File::create([
                'fileName' => $_FILES['file']['name'],
                'fileType' => $ext,
                'mime' => $mime,
                'dateUpload' => Carbon::now(),
                'file' => $base64,

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
