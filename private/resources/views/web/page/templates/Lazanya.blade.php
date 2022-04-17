@extends('web.template.layout', [
    'headerClass' => 'header--shrink'
])
@section('content')
    <div class="header-overflow"></div>

   @foreach($lazanyas as $lazanya)
       <a href="{{$lazanya->getViewLink()}}">
           {{$lazanya->getTitle()}}<br>

           @if ($lazanya->hasImage('image'))
            <img src="{{ $lazanya->getImageByTemplate('medium_featured','image') }}" alt="">
           @endif

           @if ($lazanya->hasImage('image_manset'))
            <img src="{{ $lazanya->getImageByTemplate('featured_manset','image_manset') }}" alt="">
           @endif

       </a>
   @endforeach
@endsection