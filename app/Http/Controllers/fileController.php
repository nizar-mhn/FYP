<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\file;

class fileController extends Controller
{
    public function index()
    {
        $files = File::all();

        return view('document.index', [
            'files' => $files,
        ]);
    }

    public function destroy($id)
    {
        $doc = File::find($id);
        $doc->delete();

        return redirect()->route('document');
    }

    public function update(Request $request)
    {
        $request->validate([
            'file' => 'mimes:jpeg,bmp,png,pdf,jpg',
            'name' => 'required|max:255',
        ]);

        if ($request->hasFile('file')) {           
            $path = $request->file('file')->getRealPath();
            $ext = $request->file->extension();
            $doc = file_get_contents($path);
            $base64 = base64_encode($doc);
            $mime = $request->file('file')->getClientMimeType();

            File::create([
                'name'=> $request->name .'.'.$ext,
                'file' => $base64,
                'mime'=> $mime,
            ]);

            return redirect()->route('document');
        }
    }

    public function download($id)
    {
        $document = File::find($id);

        $file_contents = base64_decode($document->file);

        return response($file_contents)
                         ->header('Cache-Control', 'no-cache private')
                         ->header('Content-Description', 'File Transfer')
                         ->header('Content-Type', $document->mime)
                         ->header('Content-length', strlen($file_contents))
                         ->header('Content-Disposition', 'attachment; filename=' . $document->name)
                         ->header('Content-Transfer-Encoding', 'binary');
    }
}
