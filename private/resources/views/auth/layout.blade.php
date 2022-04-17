@extends('admin.layout')

@push('head-page-level')
<style> .alert {margin-top: 0 !important} </style>
<link href="{{ asset('admin-assets/pages/css/login-5.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('body-class', 'login')

@section('layout-content')
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset mt-login-5-bsfix">
            <div class="login-bg" style="background-image:url({{ asset('admin-assets/pages/img/login/bg1.jpg') }})">
                <img class="login-logo" src="{{ asset('admin-assets/pages/img/login/logo.png') }}" />
            </div>
        </div>
        <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
            <div class="login-content">
                @yield('auth-content')
            </div>

            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-5 bs-reset"></div>
                    <div class="col-xs-7 bs-reset">
                        <div class="login-copyright text-right">
                            <p>Copyright &copy; Enüstkat {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
@endpush

@push('footer-page-level-scripts')
<script src="{{ asset('admin-assets/pages/scripts/login-5.min.js') }}" type="text/javascript"></script>
@endpush