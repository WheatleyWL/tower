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
    <div class="form-control d-flex flex-column bg-body-secondary px-2 pt-2 py-1 js-tower-dropzone @error($field->getName()) is-invalid @enderror"
         style="min-height: 100px; height: unset;"
         data-field-name="{{ $field->getName() }}"
         data-store-url="{{ $field->getUploadUrl() }}"
         data-edit-url="{{ $field->getEditUrl() }}"
         data-csrf="{{ csrf_token() }}"
         data-max-file-size="{{ $field->getMaxFileSize() }}"
         data-max-file-count="{{ $field->getMaxFileCount() }}"
         data-allowed-files="{{ implode(',', $field->getAllowedFileTypes()) }}"
         aria-describedby="#{{$field->getName()}}-bs-feedback">
        <div class="js-input-container d-none">
            <input type="hidden" name="{{ $field->getName() }}[]" value="" data-tag="empty">
            @if(!empty($field->getModel()->{$field->getName()}))
                @foreach($field->getModel()->{$field->getName()} as $file)
                    <div class="js-pre-fill"
                         data-id="{{ $file->id }}"
                         data-url="{{ \Illuminate\Support\Facades\Storage::url($file->path) }}"
                         data-name="{{ $file->name }}"
                         data-size="{{ $file->size }}"
                         data-title="{{ $file->title }}"
                         data-alt="{{ $file->alt }}"
                    ></div>
                @endforeach
            @endif
        </div>
        <div class="js-dropzone-container row row-cols-1 align-items-center m-0 flex-grow-1 position-relative"
             style="cursor: pointer;"
             id="tower-dropzone-{{$field->getName()}}">
            <div class="dz-message col text-center text-muted">Drag & drop files to upload or click to select</div>
            <div class="dropzone-previews row gx-2 gy-2 d-none" style="pointer-events: none;"></div>
        </div>
        <div class="border-top mt-2 px-0 text-muted">
            <small class="js-info-line">
                <div class="d-inline-block js-file-count"><span>files attached: </span><b class="js-display">1/1</b></div>
                <div class="d-inline-block d-none js-file-size"><span>| max file size: </span><b class="js-display">3MB</b></div>
                <div class="d-inline-block d-none js-file-types"><span>| accepted files: </span><b class="js-display">.jpeg</b></div>
            </small>
        </div>
    </div>
    @error($field->getName())
    <div class="invalid-feedback" id="{{$field->getName()}}-bs-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
