<?php

namespace zedsh\tower\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use zedsh\tower\Http\Requests\FileStoreRequest;
use zedsh\tower\Http\Requests\FileUpdateRequest;
use zedsh\tower\Models\File;

class FilesController extends Controller
{
    /**
     * @param FileStoreRequest $request
     * @return Response
     * @throws \Throwable
     */
    public function store(FileStoreRequest $request): Response
    {
        try {
            $storedFile = $this->saveFile($request->file('file'));
            return response()->json($storedFile->toArray(), 201);
        } catch(\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param UploadedFile $file
     * @return File
     * @throws \Throwable
     */
    protected function saveFile(UploadedFile $file): File
    {
        // TODO(wheatley): move to configuration / allow runtime adjustments?
        $path = $file->store('files', 'public');

        $uploadedFile = new File();
        $uploadedFile->path = $path;
        $uploadedFile->name = $file->getClientOriginalName();
        $uploadedFile->extension = $file->getClientOriginalExtension();
        $uploadedFile->size = $file->getSize();

        $uploadedFile->saveOrFail();

        return $uploadedFile;
    }

    /**
     * @param File $file
     * @param FileUpdateRequest $request
     * @return Response
     * @throws \Throwable
     */
    public function update(File $file, FileUpdateRequest $request): Response
    {
        $file->fill($request->all());
        $file->saveOrFail();

        return response()->json($file->toArray());
    }

    /**
     * @param File $file
     * @return Response
     * @throws \Throwable
     */
    public function destroy(File $file): Response
    {
        $file->deleteOrFail();

        return response()->json($file->toArray());
    }
}
