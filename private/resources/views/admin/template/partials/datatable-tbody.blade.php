@if (Route::has('admin.'.$modelMeta->name.'.create') && auth()->user()->can('admin.'.$modelMeta->name.'.create'))
    @if (method_exists($row, 'getCreateSubContentLink'))
        <td class="text-center">
            @if ($row->getCreateSubContentLink())
                <a href="{{ $row->getCreateSubContentLink() }}" class="btn btn-sm green"><i class="fa fa-clone"></i> Alt İçerik Oluştur</a>
            @endif
        </td>
    @endif
@endif

@if (
    (in_array(Astrotomic\Translatable\Translatable::class, class_uses($row)) && count(config('app.locales')) == 1 && method_exists($row, 'getViewLink') && !empty($row->getViewLink()))
    ||
    (!in_array(Astrotomic\Translatable\Translatable::class, class_uses($row)) && method_exists($row, 'getViewLink') && !empty($row->getViewLink()))
)
    <td class="text-center">
        @if (Route::currentRouteName() == 'admin.activity-log.index')
            <a href="{{ $row->getViewLink() }}" class="btn btn-sm blue-steel"><i class="fa fa-eye"></i> Görüntüle</a>
        @else
            <a target="_blank" href="{{ $row->getViewLink() }}" class="btn btn-sm blue-steel"><i class="fa fa-eye"></i> Görüntüle</a>
        @endif
    </td>
@endif

@if (Route::has('admin.'.$modelMeta->name.'.edit'))
    @if (auth()->user()->can('admin.'.$modelMeta->name.'.edit'))
        <td class="text-center">
            <a href="{{ $row->getEditLink() }}" class="btn btn-sm blue"><i class="fa fa-edit"></i> Düzenle</a>
        </td>
    @endif
@endif

@if (Route::has('admin.'.$modelMeta->name.'.trash') && Route::currentRouteName() == 'admin.'.$modelMeta->name.'.trash')

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.restore'))
        <td class="text-center">
            <a href="{{ $row->getRestoreLink() }}" class="btn btn-sm green-jungle"><i class="fa fa-undo"></i> Geri Al</a>
        </td>
    @endif

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
        <td class="text-center">
            <a href="{{ $row->getHardDeleteLink() }}" class="btn btn-sm red"><i class="fa fa-trash"></i> Kalıcı Olarak Sil</a>
        </td>
    @endif

@elseif (Route::has('admin.'.$modelMeta->name.'.trash'))

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.delete'))
        <td class="text-center">
            <a href="{{ $row->getDeleteLink() }}" class="btn btn-sm purple"><i class="fa fa-trash"></i> Çöpe Taşı</a>
        </td>
    @endif

@else

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
        <td class="text-center">
            <a href="{{ $row->getHardDeleteLink() }}" class="btn btn-sm red"><i class="fa fa-trash"></i> Kalıcı Olarak Sil</a>
        </td>
    @endif

@endif
