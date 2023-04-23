<?php

/**
 * @var \App\Admin\Fields\Select2Field $field
 */
$collection = $field->getCollection();
?>
<div class="form-group mb-3">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <select class="form-control select2" id="{{$field->getName()}}"
            name="{{$field->getFormName()}}" {{($field->getMultiple() ? 'multiple' : '')}} {!! $field->getAjaxUrl() ? 'data-ajax-url="' . $field->getAjaxUrl() . '"' : '' !!}>

        @if($collection)
            @if($collection instanceof \Illuminate\Support\Collection)
                @foreach($collection as $item)
                    <option
                        value="{{$item->{$field->getId()} }}" {{($field->isSelected($item->{$field->getId()}) ? 'selected' : '')}}>{{ $item->{$field->getShowField()} }}</option>
                @endforeach
            @elseif ($collection instanceof \Illuminate\Database\Eloquent\Model)
                <option value="{{$collection->{$field->getId()} }}">{{$collection->{$field->getShowField()} }}</option>
            @endif
        @endif
    </select>
    {{--    <div class="valid-feedback">--}}
    {{--        Looks good!--}}
    {{--    </div>--}}
</div>
