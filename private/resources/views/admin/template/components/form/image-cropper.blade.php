<?php
    $imageMeta = $row->imageAttributes[$name];
    $firstImageMeta = $imageMeta[0];
?>

<div class="form-group cropper" id="cropper-{{ $name }}">
    @if (!isset($label))
        <?php $label = 'Öne Çıkarılan Görsel'; ?>
    @endif

    @if (is_null($firstImageMeta['w']) && is_null($firstImageMeta['h']))
        <?php $label = sprintf('%s - %s', $label, '<span class="label label-warning">Yükleyeceğiniz görsel kırpılmayacaktır, lütfen bu görselin gözükeceği alanı hesaba katarak yükleyiniz.</span>'); ?>
    @else
        <?php $label = sprintf('%s - (%sx%s)', $label, $firstImageMeta['w'], $firstImageMeta['h']); ?>
    @endif

    @include('admin.template.components.form.label', [
        'label' => $label
    ])
    @include('admin.template.components.form.help-block')

    {{-- Crop Values --}}
    <input type="hidden" name="{{ $name }}_x">
    <input type="hidden" name="{{ $name }}_y">
    <input type="hidden" name="{{ $name }}_w">
    <input type="hidden" name="{{ $name }}_h">

    {{-- Cropper Image --}}
    <div class="cropper-image-wrapper" style="margin-top:5px;">
        <img
            class="cropper-image"
            src="{{ $row->getImage($name, $firstImageMeta['w'], $firstImageMeta['h']) }}"
            style="max-height: {{ (is_null($firstImageMeta['h']) ? '500' : $firstImageMeta['h']) }}px;max-width:100%"
        >
    </div>

    {{-- Upload Button --}}
    <div style="margin-top:10px">
        <label class="btn btn-primary btn-upload" for="imageInput_{{ $name }}" title="Upload image file">
            <input
                type="file"
                class="sr-only cropper-file-upload"
                id="imageInput_{{ $name }}"
                name="{{ $name }}"
                accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff"
                @if (isset($required) && $required == true)
                    data-rule-required="true"
                    data-msg-required="Lütfen bir görsel yükleyin."
                @endif>
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
                <span class="fa fa-upload"></span> Görsel Seçin
            </span>
        </label>

        @if (!is_null($row->$name))
            <button class="btn btn-danger btn-remove cropper-file-remove" id="removeImage" name="{{ $name }}" data-name="{{ $name }}" data-entity="{{ get_class($row) }}" data-id="{{ $row->id }}" data-toggle="confirmation" data-original-title="Silmek istediğinizden emin misiniz?" data-btn-ok-label="Kalıcı olarak sil" data-btn-cancel-label="Hayır">
                <span class="fa fa-trash"></span> Görseli Sil
            </button>
        @endif
    </div>
</div>

@push('footer-page-level-plugins')
    <script>
        generateCropper($('#cropper-{{ $name }}'), {
            viewMode: 1,
            autoCropArea: 1,
            @if (!is_null($firstImageMeta['w']) && !is_null($firstImageMeta['h']))
                aspectRatio: {{ $firstImageMeta['w'] }} / {{ $firstImageMeta['h'] }},
            @endif
            crop: function(e) {
                $('input[name="{{ $name }}_x"]').val(e.x);
                $('input[name="{{ $name }}_y"]').val(e.y);
                $('input[name="{{ $name }}_w"]').val(e.width);
                $('input[name="{{ $name }}_h"]').val(e.height);
            }
        });

        @if ($row->hasImage($name))
            $('#cropper-{{ $name }}').find('.cropper-image-wrapper').show();
        @endif
    </script>
@endpush