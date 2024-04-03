<?php

namespace App\Http\Controllers;

use App\Http\Resources\UploadResource;
use App\Models\UploadedFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    public function Upload(Request $request) {

        $fileRequestKey = 'file';
        $maxSize = 10240;

        try {
            $request->validate([
                $fileRequestKey => 'required|file|mimes:jpeg,png,mp4,svg|max:'.$maxSize,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'There was error in process of uploading file. Check the messages for details!',
                'errors' => $e->errors(),
            ], 422);
        }

        $file = $request->file($fileRequestKey);
        $fileName = Carbon::now()->format('Ymd-His').'_'.$file->getClientOriginalName();

        $newFile = new UploadedFile();
        $newFile->original_name = $file->getClientOriginalName();
        $newFile->file_name = $fileName;
        $newFile->file_path = Storage::path($file->storeAs('upload', $fileName));
        $newFile->file_size = $file->getSize();
        $newFile->mime_type = $file->getClientMimeType();
        $newFile->extension =  $file->getClientOriginalExtension();
        $newFile->description = $request->description ?? null;
        $newFile->title = $request->title ?? null;
        if ($newFile->save()) {
            return new UploadResource($newFile);
        }
        else {
            return response()->json(['message'=> 'An error occurred!'],500);
        }
    }

}
