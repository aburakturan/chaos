{{-- Errros --}}
@if(count($errors) > 0)
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-danger">
        <ul style="margin: 0;padding: 0;padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Status --}}
@if (session('status'))
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-success">
        {{ session('status') }}
    </div>
@endif

{{-- Sessions --}}
@if(session('success'))
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-success">
        {{-- <strong>Başarılı!</strong> <br> --}}
        {!! session()->get('success') !!}
    </div>
@endif

@if(session('error'))
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-danger">
        {{-- <strong>Bir hata meydana geldi!</strong> <br> --}}
        {!! session()->get('error') !!}
    </div>
@endif

@if(session('warning'))
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-warning">
        {{-- <strong>Uyarı!</strong> <br> --}}
        {!! session()->get('warning') !!}
    </div>
@endif

@if(session('info'))
    <div class="{{ $class ?? 'note' }} {{ $class ?? 'note' }}-info">
        {{-- <strong>Bilgi:</strong> <br> --}}
        {!! session()->get('info') !!}
    </div>
@endif
