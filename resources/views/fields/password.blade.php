<?php
/**
 * @var \zedsh\tower\Fields\Default\PasswordField $field
 */
?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <input type="password" class="form-control @error($field->getName()) is-invalid @enderror" id="{{$field->getName()}}" name="{{$field->getName()}}">
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
