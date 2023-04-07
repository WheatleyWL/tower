<?php
/**
 * @var \zedsh\tower\Fields\FileField $field
 */
/**
 * @var \zedsh\tower\Forms\BaseForm $form
 */
$detail = $field->getDetailValue();
?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    {{--    @dd($detail)--}}
    @if(!empty($detail))
        <div class="row">
            @foreach($detail as $file)
                <div class="card text-center" style="width: 200px; margin: 10px;">
                    <a href="{{$file->url()}}" target="_blank">
                        @if($file->isImage())
                            <img src="{{$file->url()}}" class="card-img-top" alt="{{$file->url()}}" width="140px">
                        @else
                            <i class="fa fa-file"></i>
                        @endif
                    </a>
                    <div class="card-body">
                        <p class="card-text">{{$file->originalName()}}</p>
                        @if(!empty($field->getRemoveRoute()))
                            <p><a href="{{$field->getRemovePath($file)}}" class="btn btn-danger">Удалить</a></p>
                        @endif
                        <p>
                            <label for="{{$field->getAttributeFormName($file->getId(),'title')}}">Title</label>
                            <input class="form-control" name="{{$field->getAttributeFormName($file->getId(),'title')}}" value="{{$file->getTitle()}}">
                            <label for="{{$field->getAttributeFormName($file->getId(),'alt')}}">Alt</label>
                            <input class="form-control" name="{{$field->getAttributeFormName($file->getId(),'alt')}}" value="{{$file->getAlt()}}">
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <input type="file" @if($field->getMultiple()) multiple
           @endif class="form-control @error($field->getName()) is-invalid @enderror" id="{{$field->getName()}}"
           name="{{$field->getFormName()}}">
    <div id="uploadImagesList{{$field->getName()}}">
        <div class="item template">
                        <span class="img-wrap" style="height: 225px; width: 100%; display: block;">
                            <img src="image.jpg" alt="Превьюшка" style="border-radius: 15px;height: 225px; width: 50%; display: block;">
                        </span>
            <span class="delete-link" title="Удалить" style="cursor: pointer">Удалить</span>
        </div>
    </div>
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<script>
    jQuery(document).ready(function ($) {

        var queue = {};
        var files;
        var filesForReplace;
        var imagesList = $("#uploadImagesList{{$field->getName()}}");

        var itemPreviewTemplate = imagesList.find('.item.template').clone();
        itemPreviewTemplate.removeClass('template');
        imagesList.find('.item.template').remove();

        $("#{{$field->getName()}}").on('change', function() {
            files = $(this).prop('files');
            filesForReplace = files;

            for (var i = 0; i < files.length; i++) {
                preview(files[i]);
            }
        });

        // Создание превью
        function preview(file) {
            var reader = new FileReader();
            reader.addEventListener('load', function(event) {
                var img = document.createElement('img');

                var itemPreview = itemPreviewTemplate.clone();

                itemPreview.find('.img-wrap img').attr('src', event.target.result);
                itemPreview.data('id', file.name);

                imagesList.append(itemPreview);

                queue[file.name] = file;
            });
            reader.readAsDataURL(file);
        }

        // Удаление фотографий
        imagesList.on('click', '.delete-link', function () {
            var item = $(this).closest('.item'),
                id = item.data('id');

            delete queue[id];

            var input = document.getElementById('{{$field->getName()}}');

            var dt = new DataTransfer();
            filesForReplace = Object.entries(queue);
            filesForReplace.forEach((file) => {
                dt.items.add(file[1]);
            })

            input.files = dt.files;

            item.remove();
        });

        $('body').on('submit',"form",function (e) {
            e.preventDefault();

            let $form = $(this);
            let input = document.getElementById('{{$field->getName()}}');
            var data = new FormData();
            let modelId = "{{ array_values(request()->route()->originalParameters())[0] }}";
            if(modelId.replace(/^\s+|\s+$/g, '')) {         // проверка на пустое поле
                modelId = Number("{{ array_values(request()->route()->originalParameters())[0] }}");
            }
            for (let i = 0; i < input.files.length; i += 1) {
                data.append('file'+ (i+1),input.files[i]);
            }
            data.append('modelId',modelId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: "{{ route('file.store') }}",
                data: data,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function () {
                },
                success: function (responseData) {
                    $('#success-form-alert').show();
                    setTimeout(() => {
                        $('#success-form-alert').hide();
                        $('body').off('submit');
                        $form.submit();
                    }, 300000);
                    $('body').off('submit');
                    $form.submit();
                }
            }).done(function (data) {
            }).fail(function (data) {
            });
        });
    });
</script>
