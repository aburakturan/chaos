@if (isset($rows))
    @if (Route::has('admin.'.$modelMeta->name.'.create'))
        @if (auth()->user()->can('admin.'.$modelMeta->name.'.create'))
            @if (method_exists($rows, 'first') && method_exists($rows->first(), 'getCreateSubContentLink'))
                <th class="col-xs-1">Alt İçerik</th>
            @endif
        @endif
    @endif

    @if (isset($rows))
        @if (method_exists($rows, 'first') && method_exists($rows->first(), 'getViewLink'))
            @if ((in_array(Astrotomic\Translatable\Translatable::class, class_uses($rows->first())) && count(config('app.locales')) == 1)
                ||
                (!in_array(Astrotomic\Translatable\Translatable::class, class_uses($rows->first()))))
                @if (!empty(($rows->first()->getViewLink())))
                    <th class="col-xs-1">Görüntüle</th>
                @endif
            @endif
        @endif
    @endif
@endif

@if (Route::has('admin.'.$modelMeta->name.'.edit'))
    @if (auth()->user()->can('admin.'.$modelMeta->name.'.edit'))
        <th class="col-xs-1">Düzenle</th>
    @endif
@endif

@if (Route::has('admin.'.$modelMeta->name.'.trash') && Route::currentRouteName() == 'admin.'.$modelMeta->name.'.trash')

    @if (Route::has('admin.'.$modelMeta->name.'.restore'))
        @if (auth()->user()->can('admin.'.$modelMeta->name.'.restore'))
            <th class="col-xs-1">Geri Al</th>
        @endif
    @endif

    @if (Route::has('admin.'.$modelMeta->name.'.hard-delete'))
        @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
            <th class="col-xs-1">Kalıcı Olarak Sil</th>
        @endif
    @endif

@elseif (Route::has('admin.'.$modelMeta->name.'.trash'))

    @if (auth()->user()->can('admin.'.$modelMeta->name.'.delete'))
        <th class="col-xs-1">Çöpe Taşı</th>
    @endif

@else

    @if (Route::has('admin.'.$modelMeta->name.'.hard-delete'))
        @if (auth()->user()->can('admin.'.$modelMeta->name.'.hard-delete'))
            <th class="col-xs-1">Kalıcı Olarak Sil</th>
        @endif
    @endif

@endif
