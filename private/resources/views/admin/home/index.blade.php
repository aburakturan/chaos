@extends('admin.template.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="note note-warning">
            <strong>{{ env('APP_NAME') }} Yönetim Paneline Hoşgeldiniz!</strong> <br>
            Sol taraftaki menüden ilgili başlığı seçerek işlem yapmaya başlayabilirsiniz.
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection

@push('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
@endpush
