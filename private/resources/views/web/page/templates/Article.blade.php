@extends('web.template.layout', [
    'headerClass' => 'header--shrink'
])
@section('content')
    <div class="header-overflow"></div>

   @foreach($articles as $article)
       <a href="{{$article->getViewLink()}}">
           {{$article->getTitle()}}<br>

           @if ($article->hasImage('image'))
            <img src="{{ $article->getImageByTemplate('medium_featured','image') }}" alt="">
           @endif

           @if ($article->hasImage('image_manset'))
            <img src="{{ $article->getImageByTemplate('featured_manset','image_manset') }}" alt="">
           @endif

       </a>
   @endforeach
@endsection