@extends('admin.template.master')

@section('content')

    @include('admin.template.components.buttons.page-edit')

    @component('admin.template.partials.form-edit')
        @slot('content')
            @include('admin.'.$modelMeta->name.'.form')
        @endslot
    @endcomponent

@endsection