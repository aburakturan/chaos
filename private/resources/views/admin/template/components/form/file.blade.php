<?php
$fileMeta = $row->fileAttributes[$name];
$firstFileMeta = $fileMeta[0];

if (isset($firstFileMeta['accept'])) {
    $fileAccept = implode(', ', $firstFileMeta['accept']);
}
?>

<div class="form-group file-uploader" id="file-uploader-{{ $name }}">
    @if (!isset($label))
        <?php $label = 'Dosya'; ?>
    @endif

    @if (isset($fileAccept))
        <?php $label .= ' - Dosya Tipi: '.$fileAccept; ?>
    @endif

    @include('admin.template.components.form.label', [
        'label' => $label
    ])
    @include('admin.template.components.form.help-block')

    <div class="clearfix"></div>

    {{-- File Uploader --}}
    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="input-group input-large">
            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                <span class="fileinput-filename"> </span>
            </div>
            <span class="input-group-addon btn default btn-file">
                <span class="fileinput-new">Dosya Seçin</span>
                <span class="fileinput-exists"> Değiştir</span>
                <input
                        class="file-uploader"
                        type="file"
                        name="{{ $name }}"
                        @if (isset($fileAccept))
                        accept="{{ $fileAccept }}"
                        @endif
                        @if (isset($required) && $required == true)
                        data-rule-required="true"
                        data-msg-required="Lütfen bir dosya yükleyin."
                    @endif
                >
            </span>
            <a href="javascript:void();" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">Sil</a>
        </div>

        @if (!is_null($row->$name))
            <a target="_blank" href="{{ $row->getFile($name) }}" class="btn btn-success file-show" style="margin-top:15px">
                <span class="fa fa-eye"></span> Dosyayı Görüntüle
            </a>
            <button class="btn btn-danger btn-remove file-remove" style="margin-top:15px" id="removeFile" name="{{ $name }}" data-name="{{ $name }}" data-entity="{{ get_class($row) }}" data-id="{{ $row->id }}" data-toggle="confirmation" data-original-title="Silmek istediğinizden emin misiniz?" data-btn-ok-label="Kalıcı olarak sil" data-btn-cancel-label="Hayır">
                <span class="fa fa-trash"></span> Dosyayı Sil
            </button>
        @endif
    </div>
</div>

@push('footer-page-level-plugins')
    <script>
        generateFileUploader($('#file-uploader-{{ $name }}'));
    </script>
@endpush