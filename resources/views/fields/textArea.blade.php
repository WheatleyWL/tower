<?php
/**
 * @var \zedsh\tower\Fields\TextAreaField $field
 */

?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <textarea class="form-control @error($field->getName()) is-invalid @enderror" {!! ($field->getMaxLength() !== null ? 'maxlength="' . $field->getMaxLength() .  '"' : '')!!} id="{{$field->getName()}}" name="{{$field->getName()}}">{!! $field->getValue() !!}</textarea>
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
