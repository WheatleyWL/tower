<?php
/**
 * @var \zedsh\tower\Fields\FileField $field
 */
/**
 * @var \zedsh\tower\Forms\BaseForm $form
 */
?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    @if(!empty($field->getModel()->files))
        <div class="row">
            @foreach($field->getModel()->files as $file)
                @if($file->inputFieldName === $field->getName())
                    <div class="card text-center" style="width: 200px; margin: 10px;" id="{{$field->getName()}}-{{$file->id}}">
                        <a href="{{Storage::url($file->path)}}" target="_blank">
                            @if($file->isImage())
                                <img src="{{Storage::url($file->path)}}" class="card-img-top" alt="{{url($file->path)}}" width="140px">
                            @else
                                <i class="fa fa-file"></i>
                            @endif
                        </a>
                        <div class="card-body">
                            <p class="card-text">{{$file->name}}</p>
                            <p>
                                <button class="btn btn-danger delete-file-{{$field->getName()}}" data-file-id="{{$file->id}}">Удалить</button>
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    <div class="form-control d-flex flex-column bg-body-secondary px-2 pt-2 py-1 js-tower-dropzone"
         style="min-height: 100px; height: unset;"
         data-field-name="{{ $field->getName() }}"
         data-store-url="{{ route('tower_admin::file.store') }}"
         data-csrf="{{ csrf_token() }}"
         data-max-file-size="{{ $field->getMaxFileSize() }}"
         data-max-file-count="{{ $field->getMaxFileCount() }}"
         data-allowed-files="{{ implode(',', $field->getAllowedFileTypes()) }}"
         data-template-id="tower-dropzone-{{ $field->getName() }}-template">
        <div class="js-input-container d-none"></div>
        <div class="js-dropzone-container row row-cols-1 align-items-center m-0 flex-grow-1 position-relative"
             style="cursor: pointer;"
             id="tower-dropzone-{{$field->getName()}}">
            <div class="dz-message col text-center text-muted">Drag & drop files to upload or click to select</div>
            <div class="dropzone-previews row gx-2 gy-2 d-none" style="pointer-events: none;"></div>
        </div>
        <div class="border-top mt-2 px-0 text-muted">
            <small class="js-info-line">-</small>
        </div>
        <template id="tower-dropzone-{{ $field->getName() }}-template">
            <div class="col-auto" style="pointer-events: auto; cursor: auto;">
                <div class="card" style="width: 13rem;">
                    <img src="http://localhost/storage/app/models/mainpage/mainpageslide/g4f795jLYfJTfIggQ84P4GwUxHK20M3e6n5YW3mE.jpg" class="card-img-top" alt="Test" data-dz-thumbnail>
                    <div class="card-body px-2 py-1">
                        <small class="card-title"><b data-dz-name>00001.jpg</b></small>
                    </div>
                    <div class="card-footer px-2 py-2 js-file-upload-progress">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="card-footer row align-items-center m-0 px-2 py-2 d-none js-file-error">
                        <div class="col d-inline-block px-0">
                            <small data-dz-errormessage>Error message</small>
                        </div>
                        <div class="col-auto ps-1 pe-0">
                            <button type="button" class="btn btn-sm btn-danger" data-dz-remove>
                                <i class="bi bi-x-square-fill"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-footer row align-items-center m-0 px-2 py-2 position-relative d-none js-file-controls">
                        <div class="col d-inline-block px-0">
                            <small class="text-muted" data-dz-size>32.5 MB</small>
                        </div>
                        <div class="col-auto px-1">
                            <button type="button"
                                    class="btn btn-sm btn-info"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#tower-dropzone-{{$field->getName()}}-seobox"
                                    aria-controls="tower-dropzone-{{$field->getName()}}-seobox"
                                    aria-expanded="false">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <div class="col-auto px-0">
                            <button type="button" class="btn btn-sm btn-danger" data-dz-remove>
                                <i class="bi bi-x-square-fill"></i>
                            </button>
                        </div>
                        <div class="collapse position-absolute p-1 bg-light"
                             style="left: 0; right: 0; bottom: 100%;"
                             id="tower-dropzone-{{$field->getName()}}-seobox">
                            <input class="form-control" type="text" name="title" placeholder="Title">
                            <input class="form-control mt-1" type="text" name="alt" placeholder="Alt">
                            </input>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
