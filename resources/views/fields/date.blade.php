<?php
/**
 * @var \zedsh\tower\Fields\TextField $field
 */
?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <input type="text" class="form-control date @error($field->getName()) is-invalid @enderror" id="{{$field->getName()}}" name="{{$field->getName()}}"
           value="{{$field->getValue()}}">
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
