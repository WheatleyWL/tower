<?php
/**
 * @var \zedsh\tower\Fields\FileField $field
 */
/**
 * @var \zedsh\tower\Forms\BaseForm $form
 */
?>
<div class="form-group">
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
    <div>
        <span id="files-counter-{{$field->getName()}}">Файлов загружено: 0</span>
    </div>
    <div id="hidden-inputs-container-{{$field->getName()}}" style="display:none;"></div>
    <input type="hidden" name="{{$field->getName()}}_file_ids_to_delete" value="">
    <div class="dropzone-container dropzone" id="container-{{$field->getName()}}">
        <input type="file" @if($field->getMultiple()) multiple
               @endif class="form-control @error($field->getName()) is-invalid @enderror"
               name="{{$field->getFormName()}}" id="{{$field->getName()}}"
               data-accepted-files="@if($field->getName() === "video") video/*@else image/* ,application/pdf @endif">
        @error($field->getName())
    </div>
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<script>
    initDropzoneFileField("{{$field->getName()}}", "{{$field->getFormName()}}", {{ $field->getMultiple() ? 'true' : 'false' }}, "{{ route('admin.file.store') }}", "{{ csrf_token() }}");
    initDeleteButtons("{{$field->getName()}}");
</script>
