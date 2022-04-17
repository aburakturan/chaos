@extends('admin.template.master')

@section('content')

    @component('admin.template.partials.form-create')
        @slot('content')
            @include('admin.'.$modelMeta->name.'.form')
        @endslot
    @endcomponent

@endsection