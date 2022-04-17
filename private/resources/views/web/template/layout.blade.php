<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">

    {{-- SEO Meta --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    {{-- Meta --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no">

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset(mix('assets/dist/css/style.min.css')) }}">

    {{-- Variables --}}
    <script>
        var App = {
            url: "{{ env('APP_URL') }}",
            currentUrl: "{{ url()->current() }}",
            locale: "{{ app()->getLocale() }}",
        };
    </script>

    {{-- Breadcrumbs --}}
    {{ Breadcrumbs::view('breadcrumbs::json-ld') }}
</head>
<body class="locale-{{ app()->getLocale() }}">
    {{-- Header --}}
    @yield('headerBefore')
    @include('web.template.partials.header')
    @yield('headerAfter')

    {{-- Content --}}
    @yield('contentBefore')
    @yield('content')
    @yield('contentAfter')

    {{-- Footer --}}
    @yield('footerBefore')
    @include('web.template.partials.footer')
    @yield('footerAfter')

    {{-- Script --}}
    @yield('scriptBefore')
    <script src="{{ asset(mix('assets/dist/js/scripts.min.js')) }}"></script>
    @yield('scriptAfter')
</body>
</html>
