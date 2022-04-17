@extends('admin.layout')

@section('body-class', 'page-header-fixed page-sidebar-closed-hide-logo page-content-white')

@push('head-theme-layout')
<link href="{{ asset('admin-assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin-assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{ asset('admin-assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

{{-- Translate --}}
@if (count(config('app.locales')) == 1)
    <style>
        .locale-filter {display: none;}
        .tabbable .nav-tabs.locale-tabs {display: none;}
        /*.tab-content > .tab-pane {display: block;}*/
    </style>
@endif

{{-- Cropper --}}
<style>
    .cropper-image-wrapper {
        display: none;
        background: rgba(0,0,0,0.1) url('{{ asset('admin-assets/global/plugins/cropper/src/images/cropper-bg.png') }}');
        text-align: center;
    }
</style>

{{-- Repeater --}}
<style>
    .mt-repeater .form-md-line-input {
        margin-bottom: 0;
    }

    .mt-repeater .mt-repeater-item {
        padding-top: 15px;
        border: none;
        margin-bottom: 0;
    }
</style>
@endpush

@section('layout-content')
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ route('admin.home') }}">
                    <img src="{{ asset('admin-assets/layouts/layout/img/logo.png') }}" alt="logo" class="logo-default" />
                </a>
                <div class="menu-toggler sidebar-toggler"><span></span></div>
            </div>
            <!-- END LOGO -->

            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ auth()->user()->getAvatar() }}" />
                            <span class="username username-hide-on-mobile">{{ auth()->user()->getFullName() }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ route('admin.profile.edit') }}">
                                    <i class="icon-user"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i> Çıkış Yap
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                            @if (auth()->user()->can('admin.user-switch.index'))
                                <li class="divider"> </li>
                                <li>
                                    <a href="{{ route('admin.user-switch.index') }}">
                                        <i class="icon-users"></i> Kullanıcı Değiştir
                                    </a>
                                </li>
                            @endif

                            @if (Session::has('user_switch_original_id'))
                                <li class="divider"> </li>
                                <li>
                                    <a href="{{ route('admin.user-switch.stop') }}" data-toggle="confirmation" data-original-title="Kendi kullanıcınıza dönmek istediğinizden emin misiniz?" data-btn-ok-label="Evet" data-btn-cancel-label="Hayır" data-placement="left">
                                        <i class="icon-users"></i> Eski Kullanıcıya Geçiş
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER -->

    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        @include('admin.template.sidebar')
        <!-- END SIDEBAR -->

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                @if (isset($breadCrumbName))
                    <!-- BEGIN PAGE BAR -->
                    {!! Breadcrumbs::render($breadCrumbName) !!}
                    <!-- END PAGE BAR -->
                @endif

                @if (isset($pageMeta))
                    <!-- BEGIN PAGE TITLE-->
                    @include('admin.template.partials.page-title', [
                        'title' => $pageMeta->title,
                        'desc' => $pageMeta->desc,
                    ])
                    <!-- END PAGE TITLE-->
                @endif

                {{-- Validator Message --}}
                @include('admin.template.partials.validator-messages')

                @yield('content')
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner">
            {{ date('Y') }} &copy; <a target="_blank" href="http://enustkat.com.tr">enüstkat</a> CMS
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>
@endsection

@push('footer-global-scripts')
{{-- Auto Active First Tab --}}
<script>
    $(document).ready(function() {
        if ($('.nav-tabs').length > 0) {
            $('.nav-tabs li:not(.dropdown)').first().addClass('active');
            $('.nav-tabs + .tab-content .tab-pane').first().addClass('active');
        }
    });
</script>

{{-- DatePicker --}}
<script>
    $(document).ready(function() {
        $('.date-picker').datepicker({
            language: 'tr',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1,
            pickerPosition: 'top-left'
        });
    });
</script>

{{-- DateTimePicker --}}
<script>
    $(document).ready(function() {
        $('.datetime-picker').datetimepicker({
            language: 'tr',
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1,
            pickerPosition: 'top-left'
        });
    });
</script>

{{-- jqueryValidator --}}
<script>
    $(document).ready(function() {
        // for more info visit the official plugin documentation: http://docs.jquery.com/Plugins/Validation
        var validateForms = $('.validate-form');

        validateForms.each(function() {
            var validateForm = $(this);
            var validateError = $('.alert-danger', validateForm);

            validateForm.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: '', // validate all fields including form hidden input

                rules: {
                    password_confirmation: {
                        equalTo: '#password'
                    }
                },

                invalidHandler: function(event, validator) { //display error alert on form submit
                    validateError.show();
                    App.scrollTo(validateError, -200);
                },

                errorPlacement: function(error, element) {
                    if (element.is(':checkbox')) {
                        error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                    } else if (element.is(':radio')) {
                        error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                    } else if (element.hasClass('select2')) {
                        error.insertAfter(element.parents(".form-group").find(".select2").last());
                    } else if (element.hasClass('cropper-file-upload')) {
                        error.insertAfter(element.parents(".form-group").find('> label'));
                    } else if (element.hasClass('ckeditor')) {
                        error.insertAfter(element.parents(".form-group").find('> label'));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                highlight: function(element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function(element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function(label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function(form) {
                    validateError.hide();
                    form.submit();
                }
            });
        });
    });
</script>

{{-- Check All Button for Checkboxes --}}
<script>
    $(document).ready(function() {
        $('.check-all').on('click', function() {
            $(this).parents('.form-md-checkboxes').find('.all-checkboxes').find('input').prop('checked', this.checked);
        });
    });
</script>

{{-- Select2 --}}
<script>
    $(document).ready(function() {
        $('.select2').each(function() {
            var $this = $(this);

            $this.select2({
                language: 'tr',
                placeholder: (typeof $this.attr('placeholder') != 'undefined' ? $this.attr('placeholder') : null),
                width: null,
            });
        });
    });
</script>

{{-- Cropper --}}
<script>
    function generateCropper($element, options) {
        var uploadedImageURL;
        var URL = window.URL || window.webkitURL;
        var $image = $element.find('.cropper-image');

        if (URL) {
            $('.cropper-file-upload', $element).on('change', function () {
                var files = this.files;
                var file;

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        uploadedImageURL = URL.createObjectURL(file);

                        if ($image.data('cropper')) {
                            $image.cropper('destroy');
                        }

                        $image.attr('src', uploadedImageURL).cropper(options);

                        $element.find('.cropper-image-wrapper').show();
                        $element.find('.cropper-file-remove').show();
                    } else {
                        window.alert('Lütfen görsel olan bir dosya seçin. Örneğin jpg, png uzantılarında olabilir.');
                    }
                }
            });
        } else {
            $('.cropper-file-upload', $element).prop('disabled', true).parent().addClass('disabled');
        }

        // Remove
        $('.cropper-file-remove', $element).on('click', function() {
            return false;
        });

        $('.cropper-file-remove', $element).on('confirmed.bs.confirmation', function() {
            var $destroyButton = $(this);

            var id = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                entity = $(this).attr('data-entity'),
                imageDeleteMessageElement = $('#image-delete-message'),
                getjCropId = $(this).parents('div.jCrop-wrapper').attr('data-jCropId');

            $.ajax({
                type: 'post',
                url: '{{ route('admin.image.destroy') }}',
                data: {
                    id: id,
                    name: name,
                    entity: entity
                },
                success: function(response) {
                    if(response.success) {
                        if ($image.data('cropper')) {
                            $image.cropper('destroy');
                        }

                        $image.attr('src', response.image);

                        $element.find('.cropper-image-wrapper').hide();
                        $destroyButton.hide();

                        toastr.success(response.message, response.title);
                    } else {
                        toastr.danger(response.message, response.title);
                    }
                }
            });

            return false;
        });
    }
</script>

{{-- File Uploader --}}
<script>
    function generateFileUploader($element) {
        // Remove
        $('.file-remove', $element).on('click', function() {
            return false;
        });

        $('.file-remove', $element).on('confirmed.bs.confirmation', function() {
            var $destroyButton = $(this);
            var $showFileButton = $('.file-show', $element);

            var id = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                entity = $(this).attr('data-entity');

            $.ajax({
                type: 'post',
                url: '{{ route('admin.file.destroy') }}',
                data: {
                    id: id,
                    name: name,
                    entity: entity
                },
                success: function(response) {
                    if(response.success) {
                        $destroyButton.hide();
                        $showFileButton.hide();

                        toastr.success(response.message, response.title);
                    } else {
                        toastr.danger(response.message, response.title);
                    }
                }
            });

            return false;
        });
    }
</script>
@endpush

@push('footer-theme-layout')
<script src="{{ asset('admin-assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script>
    jQuery.fn.reverse = [].reverse;

    $(document).ready(function() {
        $anchor = searchActiveLink($('.page-sidebar-menu .nav-item a'), false);

        if (typeof $anchor == 'undefined') {
            $anchor = searchActiveLink($('.page-sidebar-menu .nav-item a'), true);
        }

        if (typeof $anchor !== 'undefined') {
            $anchor.parent().addClass('active open');
            if ($anchor.parents('.sub-menu')) {
                $anchor.parents('.sub-menu').parent().addClass('active open');
            }
        }

        function searchActiveLink($elements, searchInLink) {
            var link = window.location.href,
                $anchor;

            $elements.reverse().each(function() {
                var $this = $(this);

                if (searchInLink) {
                    if (link.indexOf($this.attr('href')) > -1) {
                        $anchor = $this;
                        return false;
                    }
                } else {
                    if ($this.attr('href') == link) {
                        $anchor = $this;
                        return false;
                    }
                }
            });

            return $anchor;
        }
    });
</script>
@endpush