@php
    $class_label = $class_label ?? 'col-md-4 control-label';
@endphp

@if(isset($entity) and $entity->media)
    <div class="form-group">
        <label class="col-md-4 control-label">Média actuel</label>
        <div class="col-md-6">
            <img class="img img-responsive img-thumbnail" src="{{ $entity->media->route() }}">
        </div>
    </div>
@endif

<div class="form-group">
    <tooltip-component
        :label="{{ json_encode($field->getLabelWithRequired()) }}"
        :label-name="{{ json_encode($field->getName()) }}"
        :label-class="{{ json_encode($class_label) }}"
        :name="{{ json_encode($field->getName()) }}"
        :model="{{ json_encode(($field->getEntity()->getTable())) }}"
        :api_token="{{ json_encode(auth('admin')->user()->api_token) }}"
    >
    </tooltip-component>

    <div class="col-md-6">
        {!! Form::file($field->getName()) !!}
        {!! $errors->first($field->getName(), '<span class="help-block">:message</span>') !!}
    </div>
</div>
