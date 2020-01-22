@php
    $class_label = $class_label ?? 'col-md-4 control-label';
    $class_input = $class_input ?? 'col-md-6';
    $options = isset($options) ? $options : [0 => 'Non', 1 => 'Oui'];
    $name = $field->getName();
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

    <div class="{{  $class_input }}">
        <div class="form-check">
            @foreach($options as $key => $option)
                @php
                    $option_checked = isset($product) && $product->$name == $key // TODO ?
                        ? true
                        :  $key == $field->getValue() // get current value for exist object
                            ? true
                            : isset($checked) && $checked == $key // get default value for new object
                                ? true
                                : false;
                @endphp

                <label class="container-radio container-radio-inline">{{ $option }}
                    <input type="radio" name="{{ $field->getName() }}" value="{{ $key }}" id="{{ $field->getName() }}-{{$key}}"
                        {{ $option_checked ? 'checked="checked"' : ""  }}>
                    <span class="checkmark"></span>
                </label>
            @endforeach
        </div>

        {!! $errors->first($field->getName(), '<span class="help-block">:message</span>') !!}
    </div>
</div>
