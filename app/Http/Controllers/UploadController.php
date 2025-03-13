<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function upload()
    {
        return view('upload');
    }

    public function proses_upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'keterangan' => 'required|string',
        ]);

        $file = $request->file('file');
        $tujuan_upload = public_path('data_file');

        // Pastikan folder ada
        if (!File::exists($tujuan_upload)) {
            File::makeDirectory($tujuan_upload, 0777, true);
        }

        // Simpan file
        $file->move($tujuan_upload, $file->getClientOriginalName());

        return back()->with('success', 'File berhasil diupload!');
    }

    public function resize_upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
            'keterangan' => 'required|string',
        ]);

        $path = public_path('img/logo');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        $file = $request->file('file');
        $fileName = 'logo_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $canvas = Image::canvas(200, 200);
        $resizeImage = Image::make($file)->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });

        $canvas->insert($resizeImage, 'center');

        if ($canvas->save($path . '/' . $fileName)) {
            return back()->with('success', 'Gambar berhasil diresize dan disimpan!');
        }
        return back()->with('error', 'Gagal menyimpan gambar!');
    }

    public function dropzone()
    {
        return view('dropzone');
    }

    public function dropzone_store(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('img/dropzone'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    public function pdf_upload()
    {
        return view('pdf_upload');
    }

    public function pdf_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        $pdf = $request->file('file');
        $pdfName = 'pdf_' . time() . '.' . $pdf->extension();
        $pdf->move(public_path('pdf/dropzone'), $pdfName);

        return response()->json(['success' => $pdfName]);
    }
}