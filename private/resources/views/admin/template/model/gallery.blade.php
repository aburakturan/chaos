@extends('admin.template.master')

@include('admin.template.components.datatable')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.components.multiple-file-upload', ['enableEditModals' => true])

    @endcomponent

@endsection
