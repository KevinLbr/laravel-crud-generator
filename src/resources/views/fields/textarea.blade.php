@php
    $class_label = $class_label ?? 'col-md-4 control-label';
    $class_input = $class_input ?? 'form-control';
    $class_col_input = $class_col_input ?? 'col-md-6';
@endphp

<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}" id="form_group_{{ $field->getName() }}">
    <tooltip-component
        :label="{{ json_encode($field->getLabelWithRequired()) }}"
        :label-name="{{ json_encode($field->getName()) }}"
        :label-class="{{ json_encode($class_label) }}"
        :name="{{ json_encode($field->getName()) }}"
        :model="{{ json_encode(($field->getEntity()->getTable())) }}"
        :api_token="{{ json_encode(auth('admin')->user()->api_token) }}"
    >
    </tooltip-component>

    <div class="{{ $class_col_input }}">
        {!! Form::textarea($field->getName(), null, [
            'id' => $field->getName(),
            'class' => $class_input,
            'required' => $field->getNotNull(),
            'rows' => 5,
        ]) !!}
        {!! $errors->first($field->getName(), '<span class="help-block">:message</span>') !!}
    </div>
</div>

@push('scripts')
    <script src="{{ asset('admin/js/helpers/ckeditor/ckeditor.js') }}"></script>
@endpush
