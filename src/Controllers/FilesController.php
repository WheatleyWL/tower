<?php

namespace zedsh\tower\Controllers;

use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use zedsh\tower\Models\File;


class FilesController extends Controller
{
    public function storeFile($file, $inputFieldName) {
        $fileName = uniqid('', true) . '.' .$file->getClientOriginalExtension();

        if (! Storage::disk('local')->put("files/{$fileName}", $file)) {
            return response()->json(['Success' => false])->setStatusCode(500);
        }

        $uploadedFile = new File();
        $uploadedFile->path = Storage::path("files/{$fileName}");
        $uploadedFile->name = $file->getClientOriginalName();
        $uploadedFile->uid = $fileName;
        $uploadedFile->ext = $file->getClientOriginalExtension();
        $uploadedFile->inputFieldName = $inputFieldName;
        $uploadedFile->save();

        return $uploadedFile;
    }

    public function store(Request $request)
    {
        foreach (request()->all() as $files) {

            if(is_array($files)) {
                $inputFieldName = array_keys(request()->all())[0];
                foreach ($files as $file) {
                    $uploadedFile = $this->storeFile($file, $inputFieldName);
                }

                return response()->json([$uploadedFile])->setStatusCode(201);
            }

            if($files instanceof UploadedFile) {
                $inputFieldName = array_keys(request()->all())[0];
                $uploadedFile = $this->storeFile($files,$inputFieldName);

                return response()->json([$uploadedFile])->setStatusCode(201);
            }

        }
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(File $file)
    {
        $file->delete();
    }
}
