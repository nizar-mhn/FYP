<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\file;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

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
            $path = $request->file('file')->store('PDF');
            $realPath = storage_path()."\\app\\".str_replace('/','\\',$path);
            //D:\Documents\FYP\FYP\storage\app\PDF\4mMIQq7tYY0YWM8IX10dAf3iXxAIw0GyKCfFAkV5.pdf
            $pdf = new Pdf($realPath);
            $num = $pdf->getNumberOfPages();
            $imageData = $pdf->saveImage('image');
            $base64Img = base64_encode($imageData);
            /*$ext = $request->file->extension();
            $doc = file_get_contents($path);
            $base64 = base64_encode($doc);
            Storage::disk('local')->put($_FILES['file']['name'], $doc);
            $mime = $request->file('file')->getClientMimeType();

            /*File::create([
                'fileName' => $_FILES['file']['name'],
                'fileType' => $ext,
                'mime' => $mime,
                'noPage' => $num,
                'dateUpload' => Carbon::now(),
                'file' => $base64,
            ]);*/

            return redirect()->route('document')->with(['img' => $base64Img]);
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
