<label for="{{ $name }}">
    {!! $label ?? $name !!}

    @if (isset($locale))
        <span class="locale-filter">
            - {{ config('app.locales')[$locale]['label'] }}
        </span>
    @endif

    @if (isset($type) && $type == 'checkbox')
        <span></span>
        <span class="check"></span>
        <span class="box"></span>
    @endif

    @if (isset($required) && $required == true)
        <span class="required">*</span>
    @endif
</label>