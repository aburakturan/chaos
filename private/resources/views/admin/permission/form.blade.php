<div class="row">
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'name' => 'title',
            'label' => 'Başlık',
            'required' => true,
        ])
    </div>
    <div class="col-xs-12 col-md-6">
        @include('admin.template.components.form.text', [
            'name' => 'name',
            'label' => 'Slug',
        ])
    </div>
</div>