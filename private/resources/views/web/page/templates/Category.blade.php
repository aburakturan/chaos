@extends('web.template.layout', [
    'headerClass' => 'header--shrink'
])
@section('content')
    <div class="header-overflow"></div>

   @foreach($categorys as $category)
       <a href="{{$category->getViewLink()}}">
           {{$category->getTitle()}}<br>

           @if ($category->hasImage('image'))
            <img src="{{ $category->getImageByTemplate('medium_featured','image') }}" alt="">
           @endif

           @if ($category->hasImage('image_manset'))
            <img src="{{ $category->getImageByTemplate('featured_manset','image_manset') }}" alt="">
           @endif

       </a>
   @endforeach
@endsection