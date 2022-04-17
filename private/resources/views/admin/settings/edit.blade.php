@extends('admin.template.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-red"></i>
                    <span class="caption-subject font-red sbold">GENEL AYARLAR</span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="validate-form" action="{{ route('admin.settings.update') }}" method="post">
                    @include('admin.template.partials.validator-messages-jquery')

                    <div class="form-body">
                        @component('admin.template.partials.translation-tabs')

                            @slot('content')
                                @foreach (config('app.locales') as $lang => $langMeta)
                                    <div class="tab-pane @if ($loop->first) active @endif" id="tab_lang_{{ $lang }}">
                                        @include('admin.template.components.form.text', [
                                            'value' => setting('title_'.$lang),
                                            'name' => 'key[title_'.$lang.']',
                                            'label' => 'Site Başlığı',
                                            'required' => true,
                                            'help' => 'Arama motorlarında ve tarayıcı pencerelerinde gösterilecek olan varsayılan başlıktır.',
                                            'maxlength' => 70,
                                            'required' => ($lang == config('app.locale') ? true : false),
                                        ])

                                        @include('admin.template.components.form.textarea', [
                                            'value' => setting('meta_description_'.$lang),
                                            'name' => 'key[meta_description_'.$lang.']',
                                            'label' => 'Site Açıklaması',
                                            'required' => true,
                                            'help' => 'Arama motorlarında sayfa başlığınızın altında gösterilecek olan açıklama için varsayılan metindir.',
                                            'maxlength' => 155,
                                            'required' => ($lang == config('app.locale') ? true : false),
                                        ])
                                    </div>
                                @endforeach
                            @endslot

                        @endcomponent
                    </div>

                    <div class="form-actions">
                        @include('admin.template.components.form.save')
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>

        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-envelope-letter font-green"></i>
                    <span class="caption-subject font-green sbold">İLETİŞİM</span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="validate-form" action="{{ route('admin.settings.update') }}" method="post">
                    @include('admin.template.partials.validator-messages-jquery')

                    <div class="form-body">
                        @include('admin.template.components.form.text', [
                            'value' => setting('email'),
                            'type' => 'email',
                            'name' => 'key[email]',
                            'label' => 'E-posta',
                            'required' => true,
                        ])

                        @include('admin.template.components.form.text', [
                            'value' => setting('phone'),
                            'type' => 'tel',
                            'name' => 'key[phone]',
                            'label' => 'Telefon',
                        ])
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn green">Kaydet</button>
                                <button type="reset" class="btn default">Sıfırla</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-blue"></i>
                    <span class="caption-subject font-blue sbold">SOSYAL MEDYA HESAPLARI</span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="validate-form" action="{{ route('admin.settings.update') }}" method="post">
                    @include('admin.template.partials.validator-messages-jquery')

                    <div class="form-body">
                        @include('admin.template.components.form.text', [
                            'value' => setting('social_facebook'),
                            'type' => 'url',
                            'name' => 'key[social_facebook]',
                            'label' => 'Facebook',
                            'icon' => 'fa fa-facebook',
                            'placeholder' => 'Facebook sayfasınızın adresini yazın',
                        ])

                        @include('admin.template.components.form.text', [
                            'value' => setting('social_twitter'),
                            'type' => 'url',
                            'name' => 'key[social_twitter]',
                            'label' => 'Twitter',
                            'icon' => 'fa fa-twitter',
                            'placeholder' => 'Twitter profilinizin adresini yazın',
                        ])

                        @include('admin.template.components.form.text', [
                            'value' => setting('social_instagram'),
                            'type' => 'url',
                            'name' => 'key[social_instagram]',
                            'label' => 'Instagram',
                            'icon' => 'fa fa-instagram',
                            'placeholder' => 'Instagram profilinizin adresini yazın',
                        ])

                        @include('admin.template.components.form.text', [
                            'value' => setting('social_youtube'),
                            'type' => 'url',
                            'name' => 'key[social_youtube]',
                            'label' => 'Youtube',
                            'icon' => 'fa fa-youtube',
                            'placeholder' => 'Youtube kanalınızın adresini yazın',
                        ])

                        @include('admin.template.components.form.text', [
                            'value' => setting('social_pinterest'),
                            'type' => 'url',
                            'name' => 'key[social_pinterest]',
                            'label' => 'Pinterest',
                            'icon' => 'fa fa-pinterest',
                            'placeholder' => 'Pinterest profilinizin adresini yazın',
                        ])
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn blue">Kaydet</button>
                                <button type="reset" class="btn default">Sıfırla</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
@endsection
