<div class="row">
    <div class="col-xs-12">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-plus font-grey-mint"></i>
                    <span class="caption-subject font-grey-mint">Yeni {{ $modelMeta->singularTitle }} Ekle</span>
                </div>
            </div>

            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="validate-form" action="{{ route('admin.'.$modelMeta->name.'.store') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="node_parent_id" value="{{ request()->get('node_parent_id') }}">

                    @include('admin.template.partials.validator-messages-jquery')

                    <div class="form-body">
                        {{ $content }}
                    </div>

                    <div class="form-actions">
                        @include('admin.template.components.form.add')
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
