<?php
/**
 * @var \zedsh\tower\Fields\FileField $field
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
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<script>
    $(document).ready(function(){
        $('body').on('change','#{{$field->getName()}}',function (e) {
            e.preventDefault();

            let input = document.getElementById('{{$field->getName()}}');
            var data = new FormData();
            let arrFiles = Object.entries(input.files);
            arrFiles.forEach((item) => {
                data.append('file'+item[0],item[1]);
            })

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
                    console.log('beforeSend')
                },
                success: function (responseData) {
                    console.log('sending')
                }
            }).done(function (data) {
                console.log('afterSend')
            }).fail(function (data) {
            });
        });
    });
</script>
