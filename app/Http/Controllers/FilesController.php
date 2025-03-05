<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class FilesController extends Controller
{
    //
    public function ckeditorUpload(Request $request)
    {
        
        try {
            // dd($request->all());
            // Validate file upload
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            if (!$request->hasFile('upload') || !$request->file('upload')->isValid()) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => ['message' => 'Invalid file upload']
                ], 400);
            }

            // Lấy file và tạo filename an toàn
            $file = $request->file('upload');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = '.' . $file->getClientOriginalExtension();
            $filename = Str::slug($originalName) . '_' . Str::random(8) . $extension;

            // Xác định disk storage
            $awsKey = env('AWS_ACCESS_KEY_ID');
            $awsSecret = env('AWS_SECRET_ACCESS_KEY');

            if ($awsKey && $awsSecret && Storage::disk('s3')->getDriver()->getAdapter()) {
                $disk = 's3';
                $folder = 'ckupload';
            } else {
                $disk = 'public';
                $folder = 'ckupload';
            }

            // Upload file và lấy URL
            try {
                $path = $file->storeAs($folder, $filename, $disk);
                $url = Storage::disk($disk)->url($path);

                if ($disk === 'public') {
                    $url = Storage::url($path);
                }

                return response()->json([
                    'fileName' => $file->getClientOriginalName(),
                    'uploaded' => 1,
                    'url' => $url
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => ['message' => 'Failed to upload file: ' . $e->getMessage()]
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => $e->validator->errors()->first()]
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => 'Server error occurred']
            ], 500);
        }
    }

    public function FileUpload(Request $request)
    {
        $filename = $request->file('file')->getClientOriginalName();
        $ext = '.' . $request->file('file')->getClientOriginalExtension();
        $filename =  str_replace($ext, '', $filename);

        $link = $request->hasFile('file') ? $this->store($request->file('file'), 'Categories', $filename) : null;

        return response()->json(['success' => $link]);
    }

    public function store(UploadedFile $file, $folder = null, $filename = null)
    {
        $awsKey = env('AWS_ACCESS_KEY_ID');
        $awsSecret = env('AWS_SECRET_ACCESS_KEY');
        if ($awsKey && $awsSecret) {
            // Store the file on S3
            $disk = 's3';
        } else {
            // Store the file locally
            $disk = 'local';
            $folder = 'public/' . $folder;
        }
        $name = !is_null($filename) ? $filename . '_' . Str::random(5) : Str::random(25);
        $link =  $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            $disk
        );
        $link = Storage::disk($disk)->url($link);
        if ($disk == 'local') {
            $link = asset($link);
        }

        return $link;
    }
}
