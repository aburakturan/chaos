<div style="margin-bottom: 30px;">
    @if (auth()->user()->can('admin.'.$modelMeta->name.'.create') && (!isset($modelMeta->disableAddNew) || !$modelMeta->disableAddNew))
        @if (Route::has('admin.'.$modelMeta->name.'.create'))
            <a href="{{ route('admin.' . $modelMeta->name . '.create') }}" class="btn green"><i class="fa fa-plus"></i> Yeni Ekle </a>
        @endif
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.edit'))
        @if (Route::has('admin.'.$modelMeta->name.'.sort') && Route::currentRouteName() != 'admin.'.$modelMeta->name.'.gallery-index')
            @if (Route::currentRouteName() != 'admin.'.$modelMeta->name.'.sort' && Route::currentRouteName() != 'admin.'.$modelMeta->name.'.gallery-sort')
                <a href="{{ route('admin.' . $modelMeta->name . '.sort') }}" class="btn red-flamingo"><i class="fa fa-reorder"></i> Sırala</a>
            @else
                <a href="{{ route('admin.' . $modelMeta->name . '.index') }}" class="btn green-jungle"><i class="fa fa-list"></i> Yayındakiler </a>
            @endif
        @elseif (Route::has('admin.'.$modelMeta->name.'.gallery-sort') && Route::currentRouteName() == 'admin.'.$modelMeta->name.'.gallery-index')
            <a href="{{ route('admin.' . $modelMeta->name . '.gallery-sort', $row) }}" class="btn red-flamingo"><i class="fa fa-reorder"></i> Sırala</a>
        @endif

        @if (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.gallery-index')
            <a href="{{ $row->getEditLink() }}" class="btn blue-ebonyclay"><i class="fa fa-undo"></i> İçeriğe Geri Dön</a>
        @endif

        @if (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.gallery-sort')
            <a href="{{ $row->getGalleryLink() }}" class="btn blue-ebonyclay"><i class="fa fa-undo"></i> Galeriye Geri Dön</a>
        @endif
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
        @if (Route::has('admin.'.$modelMeta->name.'.trash'))
            @if (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.trash')
                <a href="{{ route('admin.' . $modelMeta->name . '.index') }}" class="btn green-jungle"><i class="fa fa-list"></i> Yayındakiler </a>
            @endif

            @if (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.index')
                <a href="{{ route('admin.' . $modelMeta->name . '.trash') }}" class="btn purple"><i class="fa fa-trash"></i> Çöp Kutusu </a>
            @endif
        @endif
    @endif
</div>