<div class="form-group form-md-line-input {{ $formGroupClass ?? '' }}">
    <select
        class="form-control {{ $class ?? '' }}"
        @if (isset($locale))
            name="{{ $locale }}[{{ $name }}]"
        @else
            name="{{ $name }}"
        @endif
        @if (isset($locale))
            id="{{ $name.'_'.$locale }}"
        @else
            id="{{ $name }}"
        @endif
        @if (isset($multiple) && $multiple == true)
            multiple
        @endif
        @if (isset($required) && $required == true)
            data-rule-required="true"
        @endif
        >
        @if (isset($placeholder))
            <option value="" selected disabled>{{ $placeholder }}</option>
        @endif

        @if (isset($options))
            @foreach($options as $option)
                <option
                    @if (isset($option['selected']) && $option['selected'] == true)
                        selected
                    @endif
                    value="{!! $option['value'] !!}"
                >{{ $option['label'] }}</option>
            @endforeach
        @endif
    </select>

    @include('admin.template.components.form.label')
    @include('admin.template.components.form.help-block')
</div>