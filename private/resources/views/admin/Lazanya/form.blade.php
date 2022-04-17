@component('admin.template.partials.translation-tabs')

    @slot('content')
        @foreach (config('app.locales') as $lang => $langMeta)
            <div class="tab-pane @if ($loop->first) active @endif" id="tab_lang_{{ $lang }}">

                @include('admin.template.components.form.text', [
                    'locale' => $lang,
                    'name' => 'title',
                    'label' => 'Başlık',
                    'required' => ($lang == config('app.locale') ? true : false),
                ])

                @if (!auth()->user()->hasRole('root'))
                    <div class="hidden">
                @endif

                    @include('admin.template.components.form.text', [
                        'locale' => $lang,
                        'name' => 'force_slug',
                        'label' => 'Force Slug',
                        'formGroupClass' => 'has-warning',
                        'help' => 'Bu özellik sadece yönetciler içindir. Çakışan sluglar olmaması için dikkatlice kullanmanız önerilir.',
                    ])

                @if (!auth()->user()->hasRole('root'))
                    </div>
                @endif

                @include('admin.template.components.form.textarea', [
                    'locale' => $lang,
                    'class' => 'ckeditor',
                    'name' => 'excerpt',
                    'label' => 'Açıklama',
                ])

                @include('admin.template.components.form.textarea', [
                    'locale' => $lang,
                    'class' => 'ckeditor',
                    'name' => 'content',
                    'label' => 'İçerik',
                ])

                @include('admin.template.components.form.text', [
                    'locale' => $lang,
                    'name' => 'meta_title',
                    'label' => 'Meta Title',
                    'help' => 'Bu özelliği dikkatlice kullanmalısınız. Eğer bu alana bir metin yazarsanız tarayıcı sekme başlığında bu metin gözükür. Önerilen uzunluk 75 karakter.',
                ])

                @include('admin.template.components.form.textarea', [
                    'locale' => $lang,
                    'name' => 'meta_description',
                    'label' => 'Meta Description',
                    'help' => 'Bu özelliği dikkatlice kullanmalısınız. Eğer bu alana bir metin yazarsanız arama motorları sonuçlarında açıklama alanında gözükür. Önerilen uzunluk 155 karakter.',
                ])

            </div>
        @endforeach
    @endslot

@endcomponent

<div class="row">
    <div class="col-xs-12">
        @include('admin.template.components.form.image-cropper', [
            'name' => 'image',
        ])
    </div>
</div>

