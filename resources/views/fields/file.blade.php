<?php
/**
 * @var \zedsh\tower\Fields\FileField $field
 */
/**
 * @var \zedsh\tower\Forms\BaseForm $form
 */
$detail = $field->getDetailValue();
//dd($field->getModel()->files);
?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    {{--    @dd($detail)--}}
    @if(!empty($field->getModel()->files))
        <div class="row">
            @foreach($field->getModel()->files as $file)
                @if($file->inputFieldName === $field->getName())
                    {{--                @dd(url($file->path))--}}
                    {{--            @dd($file)--}}
                    <div class="card text-center" style="width: 200px; margin: 10px;" id="{{$field->getName()}}-{{$file->id}}">
                        <a href="{{url($file->path)}}" target="_blank">
                            @if($file->isImage())
                                <img src="{{url($file->path)}}" class="card-img-top" alt="{{url($file->path)}}" width="140px">
                            @else
                                <i class="fa fa-file"></i>
                            @endif
                        </a>
                        <div class="card-body">
                            <p class="card-text">{{$file->name}}</p>
                            {{--                        @if(!empty($field->getRemoveRoute()))--}}
                            {{--                            <p><a href="{{$field->getRemovePath($file)}}" class="btn btn-danger">Удалить</a></p>--}}
                            {{--                        @endif--}}
                            <p>
                                <button class="btn btn-danger delete-file-{{$field->getName()}}" data-file-id="{{$file->id}}">Удалить</button>
                                {{--                            <label for="{{$field->getAttributeFormName($file->getId(),'title')}}">Title</label>--}}
                                {{--                            <input class="form-control" name="{{$field->getAttributeFormName($file->getId(),'title')}}" value="{{$file->getTitle()}}">--}}
                                {{--                            <label for="{{$field->getAttributeFormName($file->getId(),'alt')}}">Alt</label>--}}
                                {{--                            <input class="form-control" name="{{$field->getAttributeFormName($file->getId(),'alt')}}" value="{{$file->getAlt()}}">--}}
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
    Dropzone.autoDiscover = false;

    document.addEventListener("DOMContentLoaded", function () {

        let uniqueId = "{{$field->getName()}}";
        let fieldName = "container-" + uniqueId;
        let fileInput = document.getElementById(fieldName);
        let allFileIdsForHiddenInput = [];
        let allFilesForHiddenInput = [];


        if (fileInput) {
            let formName = "<?= $field->getFormName() ?>";
            let isMultiple = <?= $field->getMultiple() ? 'true' : 'false' ?>;
            let dropzoneOptions = {
                url: '{{ route('file.store') }}', // Update with the URL where the files should be uploaded
                paramName: formName,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                maxFilesize: 15, // MB
                acceptedFiles: fileInput.getAttribute('data-accepted-files'),
                addRemoveLinks: true,
                dictDefaultMessage: "Drag and drop files here or click to select",
                createImageThumbnails: true,
                previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"><div class="dz-size"><span data-dz-size></span></div><div class="dz-filename"><span data-dz-name></span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div><div class="dz-success-mark"><span class="dz-success-mark-svg"></span></div><div class="dz-error-mark"><span class="dz-error-mark-svg"></span></div></div>',
                init: function () {
                    let filesCounter = document.getElementById("files-counter-{{$field->getName()}}");
                    let filesCount = 0;
                    // Add any additional initialization code if required
                    this.on("addedfile", function (file) {
                    });
                    console.log('success init');
                    console.log(allFilesForHiddenInput);

                    this.on("success", function(file, response) {
                        filesCount++;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;
                        // console.log(response);

                        let hiddenInputsContainer = document.getElementById("hidden-inputs-container-{{$field->getName()}}");
                        let hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";

                        if (isMultiple) {
                            hiddenInput.name = "{{$field->getName()}}_file_ids[]"; // Update this name according to your needs
                            let { id,name } = response[0];
                            allFileIdsForHiddenInput.push(id);
                            allFilesForHiddenInput.push([id,name]);
                            console.log(allFilesForHiddenInput);
                            console.log("allFileIdsForHiddenInput",allFileIdsForHiddenInput);
                            hiddenInput.value = allFileIdsForHiddenInput;
                            // hiddenInput.value.push(Object.entries(response[0]));
                            // console.log("response:    ", id);
                            // console.log("response:    ", response[{ id }]);
                            // console.log("response:    ", Object.entries(response[0]));
                            {{--console.log("{{$field->getName()}}_file_ids[]:    ", hiddenInput.value);--}}
                        } else {
                            hiddenInput.name = "{{$field->getName()}}_file_id"; // Update this name according to your needs
                            hiddenInput.value = response[0]["id"];
                            console.log(hiddenInput.value);
                        }

                        if (hiddenInputsContainer.innerHTML === "") {
                            // console.log(hiddenInput.value);
                            hiddenInputsContainer.appendChild(hiddenInput);
                        } else {
                            // hiddenInputsContainer.parentNode.replaceChild(hiddenInput,hiddenInputsContainer);
                            console.log("allFileIdsForHiddenInput:    ",allFileIdsForHiddenInput);
                            document.querySelectorAll("input[name='{{$field->getName()}}_file_ids[]']")[0].value = allFileIdsForHiddenInput;
                            console.log(".value:    ",document.querySelectorAll("input[name='{{$field->getName()}}_file_ids[]']")[0].value);
                        }

                        // console.log("success");
                    });

                    this.on("removedfile", function(file) {

                        if (isMultiple) {
                            console.log(file.name)
                            //
                            let indexOfFileRemoveFromAttach = allFilesForHiddenInput.findIndex(function (element) {
                                return element[1] === file.name;
                            });
                            let fileIdForRemoveAttach = allFilesForHiddenInput[indexOfFileRemoveFromAttach][0];
                            console.log(fileIdForRemoveAttach);
                            let index = allFileIdsForHiddenInput.indexOf(fileIdForRemoveAttach);
                            if (index !== -1) {
                                allFileIdsForHiddenInput.splice(index, 1);
                                // console.log(allFileIdsForHiddenInput);
                                document.querySelectorAll("input[name='{{$field->getName()}}_file_ids[]']")[0].value = allFileIdsForHiddenInput;
                                {{--console.log("Log from remove method:  ",document.getElementsByName("{{$field->getName()}}_file_ids[]").value)--}}
                            }
                        } else {
                            document.querySelectorAll("input[name='{{$field->getName()}}_file_id']")[0].value = "";
                        }
                        filesCount--;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;
                    });

                    this.on("reset", function() {
                        filesCount = 0;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;
                    });
                },
                success: function (file, response) {
                    // Handle successful uploads
                    console.log('success');
                    // console.log(response);
                },
                error: function (file, response) {
                    // Handle errors during the upload
                }
            };

            if (isMultiple) {
                dropzoneOptions["maxFiles"] = null;
            } else {
                dropzoneOptions["maxFiles"] = 1;
            }

            new Dropzone(fileInput, dropzoneOptions);
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let deleteButtons = document.querySelectorAll(".delete-file-{{$field->getName()}}");
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener("click", function (event) {
                event.preventDefault();
                // event.stopPropagation();
                let fileId = this.getAttribute("data-file-id");
                // let fileId = response[0].id;
                let fileIdsToDelete = document.getElementsByName("{{$field->getName()}}_file_ids_to_delete")[0];
                if (!fileIdsToDelete.value) {
                    fileIdsToDelete.value += fileId;
                } else {
                    fileIdsToDelete.value += "," + fileId;
                }
                let hideCard = document.getElementById('{{$field->getName()}}-' + fileId);
                hideCard.style.display = 'none';
            });
        }
    });

</script>
