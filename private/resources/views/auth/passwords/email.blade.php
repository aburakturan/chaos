@extends('auth.layout')

@section('auth-content')
<form action="{{ route('password.email') }}" method="post">
    @csrf

    <h3 class="font-green">Şifre Sıfırlama Talebi</h3>
    <p>E-posta adresinizi yazdıktan sonra şifrenizi sıfırlamak isteyip istemediğinize dair bir email alacaksınız. Bu emaildaki şifre sıfırlama linkine tıklayarak yeni bir şifre belirleyebileceksiniz.</p>

    @include('admin.template.partials.validator-messages')

    <div class="form-group">
        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="E-posta" name="email" value="{{ old('email') }}" autofocus />
    </div>
    <div class="form-actions">
        <a href="{{ route('login') }}" class="btn green btn-outline">Geri</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Gönder</button>
    </div>
</form>
@endsection
