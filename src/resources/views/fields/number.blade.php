@php
    $class_label = $class_label ?? 'col-md-4 control-label';
    $class_input = $class_input ?? 'form-control';
@endphp

<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}" id="form_group_{{ $field->getName() }}">
    <label class="col-md-4 control-label">{{ $field->getLabelWithRequired() }}</label>

    <div class="col-md-6">
        @if(!$field->hasOptions())
            {!! Form::number($field->getName(), null, [
                'class' => $class_input,
                'id' => $field->getName(),
                'required' => $field->getNotNull()
            ]) !!}

            @if(isset($indications))
                {{$indications}}
            @endif

            {!! $errors->first($field->getName(), '<span class="help-block">:message</span>') !!}
        @else
            {!! Form::select($field->getName(), $field->getOptions(), $field->getValue(), [
                'id' => $field->getName(),
                'class' => $class_input,
                'required' => $field->getNotNull()
             ]) !!}

            {!! $errors->first($field->getName(), '<span class="help-block">:message</span>') !!}
        @endif
    </div>
</div>
