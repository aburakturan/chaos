{{-- Load Css Files --}}
@push('head-page-level')
<link href="{{ asset('admin-assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin-assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
@endpush

{{-- Load JS Files --}}
@push('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js') }}" type="text/javascript"></script>

{{-- Init Library --}}
<script>
$(document).ready(function() {
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        disableImageResize: false,
        autoUpload: false,
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
    })

    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
        $.ajax({
            type: 'HEAD'
        }).fail(function () {
            $('<div class="alert alert-danger"/>').text('Upload server currently unavailable - ' + new Date()) .appendTo('#fileupload');
        });
    }
});
</script>
@endpush

<form id="fileupload" action="{{ route('admin.'.$row->modelMeta['name'].'.gallery-store', $row) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" val="{{ $row->id }}">
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-7">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn green fileinput-button">
                <i class="fa fa-picture-o"></i> <span> Dosya Ekle </span>
                <input type="file" name="galleryImages[]" multiple="">
            </span>

            <button type="submit" class="btn blue start">
                <i class="fa fa-upload"></i>
                <span> Yükle </span>
            </button>

            <button type="reset" class="btn warning cancel">
                <i class="fa fa-ban-circle"></i>
                <span> Yüklemeyi İptal Et </span>
            </button>

            <button type="button" class="btn red delete">
                <i class="fa fa-trash"></i>
                <span> Kalıcı Olarak Sil </span>
            </button>

            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"> </span>
        </div>

        <!-- The global progress information -->
        <div class="col-lg-5 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
            </div>

            <!-- The extended global progress information -->
            <div class="progress-extended"> &nbsp; </div>
        </div>
    </div>

    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped clearfix">
    <tbody class="files">

        @if ($row->gallery->isNotEmpty())
            @foreach($row->gallery as $galleryItem)
                <tr class="template-download fade in">
                    <td>
                        <span class="preview">
                            <a href="{{ $galleryItem->getGalleryImageByTemplate('thumbnail') }}" title="{{ $galleryItem->image }}" download="{{ $galleryItem->image }}" data-gallery="">
                                <img src="{{ $galleryItem->getGalleryImageByTemplate('thumbnail') }}">
                            </a>
                        </span>
                    </td>
                    <td>
                        <p class="name">
                            <a href="{{ $galleryItem->getGalleryImageByTemplate('thumbnail') }}" title="6818f34389a947b0e9491ec80e84bc84.jpg" download="{{ $galleryItem->image }}" data-gallery="">
                                {{ $galleryItem->image }}
                            </a>
                        </p>
                    </td>
                    <td>
                        <span class="size"></span>
                    </td>
                    <td align="right">
                        @if (auth()->user()->can('admin.'.$modelMeta->name.'.gallery-update'))
                            @if ($enableEditModals ?? false)
                                <button type="button" class="btn blue" data-toggle="modal" href="#edit-modal-{{ $galleryItem->id }}">
                                    <i class="fa fa-edit"></i>
                                    <span>Düzenle</span>
                                </button>
                            @endif
                        @endif
                        <button type="button" class="btn red delete" data-type="DELETE" data-url="{{ route('admin.'.$row->modelMeta['name'].'.gallery-hard-delete', $galleryItem) }}">
                            <i class="fa fa-trash-o"></i>
                            <span>Kalıcı Olarak Sil</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
    </table>
</form>

@if (auth()->user()->can('admin.'.$modelMeta->name.'.gallery-update'))
    @if ($enableEditModals ?? false)
        {!! $popup !!}
    @endif
@endif

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td><span class="preview"></span></td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger label label-danger"></strong>
        </td>
        <td>
            <p class="size">İşleniyor...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </td>
        <td align="right"> {% if (!i && !o.options.autoUpload) { %}
            <button type="button" class="btn blue start" disabled>
                <i class="fa fa-upload"></i>
                <span>Yükle</span>
            </button> {% } %} {% if (!i) { %}
            <button type="button" class="btn red cancel">
                <i class="fa fa-ban"></i>
                <span>İptal</span>
            </button> {% } %}
        </td>
    </tr>
    {% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-download fade">
    <td>
        <span class="preview"> {% if (file.thumbnailUrl) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                <img src="{%=file.thumbnailUrl%}">
            </a> {% } %} </span>
    </td>
    <td>
        <p class="name"> {% if (file.url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
            <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
        <div>
            <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
    <td>
        <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td align="right"> {% if (file.deleteUrl) { %}
        <button type="button" class="btn red delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
            <i class="fa fa-trash-o"></i>
            <span>Kalıcı Olarak Sil</span>
        </button>
        <input type="checkbox" name="delete" value="1" class="toggle"> {% } else { %}
        <button type="button" class="btn yellow cancel">
            <i class="fa fa-ban"></i>
            <span>Cancel</span>
        </button> {% } %} </td>
</tr> {% } %} </script>
