<?php
    if (isset($value)) {
        $textValue = $value;
    } elseif (isset($row) && !is_null($row->id)) {
        if (isset($locale)) {
            if (isset($row->translate($locale)->$name)) {
                $textValue = old($name, $row->translate($locale)->$name);
            } else {
                $textValue = null;
            }
        } else {
            $textValue = old($name, $row->$name);
        }
    } else {
        if (isset($locale)) {
            $textValue = old($name.'_'.$locale);
        } else {
            $textValue = old($name);
        }
    }
?>

<div class="form-group form-md-line-input {{ $formGroupClass ?? '' }}">
    @if (isset($icon))
        <div class="input-icon">
    @endif

    <input
        class="form-control {{ $class ?? '' }}"
        type="{{ $type ?? 'text' }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $textValue }}"

        @if (isset($locale))
            id="{{ $name.'_'.$locale }}"
        @else
            id="{{ $name }}"
        @endif

        @if (isset($locale))
            name="{{ $locale }}[{{ $name }}]"
        @else
            name="{{ $name }}"
        @endif

        @if (isset($required) && $required == true)
            data-rule-required="true"
        @endif

        @if (isset($type) && $type == 'email')
            data-rule-email="true"
        @endif

        @if (isset($type) && $type == 'url')
            data-rule-url="true"
        @endif

        @if (isset($maxlength))
            data-rule-maxlength="{{ $maxlength }}"
        @else
            data-rule-maxlength="191"
        @endif

        @if (isset($minlength))
            data-rule-minlength="{{ $minlength }}"
        @endif
    >

    @include('admin.template.components.form.label')
    @include('admin.template.components.form.help-block')
    @include('admin.template.components.form.icon')

    @if (isset($icon))
        </div>
    @endif
</div>