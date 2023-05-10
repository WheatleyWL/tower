<?php
/**
 * @var \zedsh\tower\Fields\Default\DateField $field
 */
?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <input type="text"
           class="form-control date @error($field->getName()) is-invalid @enderror"
           id="{{$field->getName()}}"
           name="{{$field->getName()}}"
           value="{{$field->getValue()}}"
           aria-describedby="#{{$field->getName()}}-bs-feedback">
    @error($field->getName())
    <div class="invalid-feedback" id="{{$field->getName()}}-bs-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
