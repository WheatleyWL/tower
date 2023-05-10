<?php
/**
 * @var \zedsh\tower\Fields\Default\SectionField $field
 */
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>{{$field->getTitle()}}</h3>
</div>
<div>
    {!! $field->renderNested() !!}
</div>
