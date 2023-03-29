<?php

namespace zedsh\tower\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use zedsh\tower\Models\File;


class FilesController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->files as $file) {
            $fileName = uniqid('', true) . '.' .$file->getClientOriginalExtension();

            if (! Storage::disk('local')->put("files/{$fileName}", $file)) {
                return response()->json([0 => 'Error'])->setStatusCode(500);
            }
            
            File::create([
                'path' => Storage::path("files/{$fileName}"),
                'name' => $file->getClientOriginalName(),
                'uid' => $fileName,
            ]);

        };

        return response()->json([1 => 'Success'])->setStatusCode(201);
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(File $file)
    {
        //
    }
}
