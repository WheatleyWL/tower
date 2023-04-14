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

        if (! Storage::put("files/{$fileName}", $file)) {
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
        foreach (request()->all() as $field) {
            $inputFieldName = array_keys(request()->all())[0];

            if(is_array($field)) {
                foreach ($field as $file) {
                    $uploadedFile = $this->storeFile($file, $inputFieldName);
                }
            }

            if($field instanceof UploadedFile) {
                $uploadedFile = $this->storeFile($field,$inputFieldName);
            }

            return response()->json([$uploadedFile])->setStatusCode(201);
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
