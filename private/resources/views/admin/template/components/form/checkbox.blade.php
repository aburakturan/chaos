<?php $type = 'checkbox'; ?>
<div class="form-group form-md-checkboxes {{ $formGroupClass ?? '' }}">
    @include('admin.template.components.form.label')
    <div style="margin-top: -5px; margin-bottom: 10px; font-size: 12px">
        @include('admin.template.components.form.help-block')
    </div>

    @if (isset($checkAll) && $checkAll == true)
        <div class="md-checkbox pull-right">
            <input type="checkbox" id="check_all_{{ $name }}" name="checkboxes1[]" value="1" class="check-all md-check">
            <label for="check_all_{{ $name }}">
                <span></span>
                <span class="check"></span>
                <span class="box"></span> Tümü Seç
            </label>
        </div>
    @endif

    <div class="all-checkboxes md-checkbox-list">
        @if (isset($inputs))
            <?php $i = 0; ?>
            @foreach($inputs as $input)
                <?php $i++; ?>
                <div class="md-checkbox {{ $input['class'] ?? '' }}">
                    <input
                        class="md-check"
                        @if (isset($input['value']))
                        value="{{ $input['value'] }}"
                        @else
                        value="{{ old($input['name'], $input['name']) }}"
                        @endif
                        type="{{ $type ?? 'checkbox' }}"
                        id="{{ $input['name'] }}_{{ $i }}"
                        name="{{ $input['name'] }}"
                        @if (isset($input['checked']) && $input['checked'] == true)
                        checked
                        @endif
                        @if (isset($input['disabled']) && $input['disabled'] == true)
                        disabled
                        @endif
                        @if (isset($required) && $required == true)
                        data-rule-required="true"
                        @endif
                    >

                    @include('admin.template.components.form.label', [
                        'name' => $input['name'].'_'.$i,
                        'label' => $input['label'],
                        'required' => false,
                    ])
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="clearfix"></div>
