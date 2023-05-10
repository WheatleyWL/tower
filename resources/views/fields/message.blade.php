<?php
/**
 * @var \zedsh\tower\Fields\Default\MessageField $field
 */
?>
<div class="alert {{ $field->getStyle() }}" role="alert">
    @if(!empty($field->getTitle()))
        <div class="h4 alert-heading">{{ $field->getTitle() }}</div>
    @endif
    <span>{{ $field->getMessage() }}</span>
</div>
