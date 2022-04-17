@component('admin.template.partials.translation-tabs')

    @slot('content')

        @if (auth()->user()->can('admin.'.$modelMeta->name.'.create'))
            @include('admin.template.components.form.text', [
                'name' => 'name',
                'label' => 'Cümle Adı',
                'required' => true,
            ])
        @endif

        @foreach (config('app.locales') as $lang => $langMeta)
            <div class="tab-pane @if ($loop->first) active @endif" id="tab_lang_{{ $lang }}">

                @include('admin.template.components.form.textarea', [
                    'locale' => $lang,
                    'name' => 'content',
                    'label' => 'İçerik',
                    'class' => 'ckeditor',
                    'required' => ($lang == config('app.locale') ? true : false),
                ])

            </div>
        @endforeach
    @endslot

@endcomponent