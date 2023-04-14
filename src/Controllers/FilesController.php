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
use zedsh\tower\Traits\StoreFile;


class FilesController extends Controller
{
    use StoreFile;

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
