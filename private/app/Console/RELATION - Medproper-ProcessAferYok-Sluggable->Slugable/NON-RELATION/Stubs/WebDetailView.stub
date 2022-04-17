@extends('web.template.layout', [
    'headerClass' => 'header--shrink'
])
@section('content')
    <div class="header-overflow"></div>

    <h1> {{ $row->getTitle() }} </h1>
    <h1> {!!  $row->getExcerpt()  !!} </h1>
    <h1> {{ $row->getContent() }} </h1>

    <img src="{{ $row->getImageByTemplate('medium_featured') }}" alt="">
@endsection