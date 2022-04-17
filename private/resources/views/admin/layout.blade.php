<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>
            @if (isset($pageMeta) && !empty($pageMeta->title))
                {{ $pageMeta->title}} - Yönetim Paneli
            @else
                Yönetim Paneli
            @endif
        </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Enüstkat - Özgür KARAGÖZ - ozgur@enustkat.com.tr" name="author" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ asset('admin-assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('admin-assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        @stack('head-theme-layout')
        <!-- END THEME LAYOUT STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ asset('admin-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/cropper/dist/cropper.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin-assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        @stack('head-page-level')
        <!-- END PAGE LEVEL STYLES -->

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- GLOBAL VARIABLES -->
        <script>
            var ASSETS_URL = '{{ asset('/') }}'
        </script>
    </head>
    <!-- END HEAD -->

    <body class="@yield('body-class')">
        @yield('layout-content')

        <!--[if lt IE 9]>
        <script src="{{ asset('admin-assets/global/plugins/respond.min.js') }}"></script>
        <script src="{{ asset('admin-assets/global/plugins/excanvas.min.js') }}"></script>
        <script src="{{ asset('admin-assets/global/plugins/ie8.fix.min.js') }}"></script>
        <![endif]-->

        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ asset('admin-assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('admin-assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        @stack('footer-global-scripts')
        <!-- END THEME GLOBAL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        @stack('footer-theme-layout')
        <!-- END THEME LAYOUT SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ asset('admin-assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/jquery-validation/js/localization/messages_tr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/select2/js/i18n/tr.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/cropper/dist/cropper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js') }}"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.tr.js') }}"></script>s
        @stack('footer-page-level-plugins')
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        @stack('footer-page-level-scripts')
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
</html>