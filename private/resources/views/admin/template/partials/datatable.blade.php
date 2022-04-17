<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold">
                @if (isset($title))
                    {{ $title }}
                @elseif (Route::currentRouteName() == 'admin.'.$modelMeta->name.'.trash')
                    Çöp Kutusundaki {{ $modelMeta->pluralTitle }}
                @else
                    Tüm {{ $modelMeta->pluralTitle }}
                @endif
            </span>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <table class="datatable table table-striped table-bordered table-hover"
               data-group-column="{{ $groupColumn ?? '' }}"
               data-export-columns="{{ $exportColumns ?? '' }}"
               data-export-columns-sizes="{{ $exportColumnsSizes ?? '' }}">
            <thead>
                <tr>
                    {{ $thead }}

                    @if (isset($theadAfter))
                        {{ $theadAfter }}
                    @else
                        @include('admin.template.partials.datatable-thead')
                    @endif
                </tr>
            </thead>

            @if (isset($tfoot))
                <tfoot>
                    <tr>
                        {{ $tfoot }}
                    </tr>
                </tfoot>
            @endif

            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>
</div>