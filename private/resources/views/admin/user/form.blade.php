<div class="row">
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'name' => 'first_name',
            'label' => 'İsim',
            'required' => true,
        ])
    </div>
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'name' => 'last_name',
            'label' => 'Soyisim',
            'required' => true,
        ])
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        @include('admin.template.components.form.text', [
            'name' => 'email',
            'label' => 'E-posta',
            'type' => 'email',
            'required' => true,
        ])
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'value' => '',
            'type' => 'password',
            'name' => 'password',
            'label' => 'Şifre',
            'help' => 'Yeni şifre belirmek için bu alanı kullanabilirsiniz',
            'minlength' => 5,
        ])
    </div>
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'type' => 'password',
            'name' => 'password_confirmation',
            'label' => 'Şifre - Tekrar',
            'help' => 'Yeni şifre belirmek için bu alanı kullanabilirsiniz',
            'minlength' => 5,
        ])
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        @include('admin.template.components.form.checkbox', [
            'name' => 'roles',
            'label' => 'Roller',
            'required' => true,
            'inputs' => $roleInputs,
            'checkAll' => true,
        ])
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-xs-12">
        @include('admin.template.components.form.checkbox', [
            'name' => 'permissions',
            'label' => 'Yetkiler',
            'inputs' => $permissionInputs,
            'checkAll' => true,
        ])
    </div>
</div>