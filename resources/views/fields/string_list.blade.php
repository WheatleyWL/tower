<?php
/**
 * @var \zedsh\tower\Fields\Default\StringListField $field
 */
$entries = $field->getEntries();
?>
<div class="form-group mb-3 js-string-list-field" data-name="{{$field->getName()}}">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <div class="js-input-container">
        @foreach($entries as $entry)
            <div class="input-group mb-3 js-input-line">
                <input type="text" class="form-control" name="{{$field->getName()}}[]" value="{{$entry}}">
                <button class="btn btn-outline-danger" type="button">Удалить</button>
            </div>
        @endforeach
        @if(empty($entries))
            <div class="input-group mb-3 js-input-line">
                <input type="text" class="form-control" name="{{$field->getName()}}[]">
                <button class="btn btn-outline-danger" type="button">Удалить</button>
            </div>
        @endif
    </div>
    <a href="javascript:;" class="js-add-button">Добавить</a>
</div>
