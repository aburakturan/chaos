<div style="margin-bottom: 30px;">
    @if (auth()->user()->can('admin.'.$modelMeta->name.'.create') && (!isset($modelMeta->disableAddNew) || !$modelMeta->disableAddNew))
        @if (Route::has('admin.'.$modelMeta->name.'.create'))
            <a href="{{ route('admin.' . $modelMeta->name . '.create') }}" class="btn green"><i class="fa fa-plus"></i> Yeni Ekle </a>
        @endif
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.gallery-index'))
        @if (Route::has('admin.'.$modelMeta->name.'.gallery-index'))
            <a href="{{ $row->getGalleryLink() }}" class="btn grey-gallery"><i class="fa fa-photo"></i> Galeri </a>
        @endif
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.delete'))
        @if (Route::has('admin.'.$modelMeta->name.'.trash'))
            @if (is_null($row->deleted_at))
                <a href="{{ $row->getDeleteLink() }}" class="btn purple"><i class="fa fa-trash"></i> Çöpe Taşı </a>
            @endif
        @endif
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
        <a href="{{ $row->getHardDeleteLink() }}" class="btn red"><i class="fa fa-trash"></i> Kalıcı Olarak Sil </a>
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.restore'))
        @if (!is_null($row->deleted_at))
            <a href="{{ $row->getRestoreLink() }}" class="btn green-jungle"><i class="fa fa-undo"></i> Geri Al </a>
        @endif
    @endif
</div>