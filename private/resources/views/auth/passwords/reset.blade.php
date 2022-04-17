@extends('auth.layout')

@section('auth-content')
<form action="{{ route('password.request') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <h3 class="font-green">Yeni Şifre Belirleme</h3>
    <p>Bu formu kullanarak unuttuğunuz şifreniz yerine yeni bir şifre belirleyip giriş yapabilirsiniz.</p>

    @include('admin.template.partials.validator-messages')

    <div class="form-group">
        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="E-posta" name="email" value="{{ $email ?? old('email') }}" autofocus required />
    </div>
    <div class="row">
        <div class="col-xs-6">
            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Şifre" name="password" required />
        </div>
        <div class="col-xs-6">
            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Şifre (Tekrar)" name="password_confirmation" required />
        </div>
    </div>
    <div class="form-actions">
        <a href="{{ route('login') }}" class="btn red btn-outline">İptal</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Kaydet</button>
    </div>
</form>
@endsection
