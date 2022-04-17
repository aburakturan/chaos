@extends('auth.layout')

@push('head')
<style> .alert {margin-top: -60px !important} </style>
@endpush

@section('auth-content')
<h1>Yönetici Girişi</h1>
<p>Hoşgeldiniz, aşağıdaki formu kullanarak yönetim paneline giriş yapabilirsiniz. Eğer şifrenizi unuttuysanız "şifremi unuttum" linkine tıklayarak email adresinizi yazmanız halinde sistem size yeni bir şifre atayıp bu şifreyi size gönderecektir.</p>
<form action="{{ route('login') }}" class="login-form" method="post">
    @csrf

    @include('admin.template.partials.validator-messages')

    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>Lütfen email adresinizi ve şifrenizi yazınız.</span>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="E-posta" name="email" required autofocus />
        </div>
        <div class="col-xs-6">
            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Şifre" name="password" required />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="rem-password">
                <label class="rememberme mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} /> Beni Hatırla
                    <span></span>
                </label>
            </div>
        </div>
        <div class="col-sm-8 text-right">
            <div class="forgot-password">
                <a href="{{ route('password.request') }}" class="forget-password">Şifremi Unuttum</a>
            </div>
            <button class="btn green" type="submit">Giriş Yap</button>
        </div>
    </div>
</form>
@endsection