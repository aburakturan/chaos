<div class="row">
    <div class="col-xs-12">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-pencil font-grey-mint"></i>
                    <span class="caption-subject font-grey-mint">
                        {{ $modelMeta->singularTitle }}

                        @if (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.edit')
                            Düzenle
                        @elseif (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.show')
                            Görüntüle
                        @endif
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                @if (Route::has('admin.'.$modelMeta->name.'.update'))
                    <form class="validate-form" action="{{ route('admin.'.$modelMeta->name.'.update', $row) }}" method="post" enctype="multipart/form-data">
                        {{ method_field('PUT') }}

                        @include('admin.template.partials.validator-messages-jquery')

                        <div class="form-body">
                            {{ $content }}
                        </div>

                        <div class="form-actions">
                            @include('admin.template.components.form.save')
                        </div>
                    </form>
                    <!-- END FORM-->
                @else
                    <div class="form-body">
                        {{ $content }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
