@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('thead')
            @foreach(config('app.locales') as $locale => $localeMeta)
                <th>Başlık <span class="locale-filter">- {{ $localeMeta['label'] }}</span></th>
            @endforeach
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <tr>
                    @foreach(config('app.locales') as $locale => $localeMeta)
                        <td>
                            {{-- Set depth divider --}}
                            @if ($row->depth > 0 && $row->getTitle($locale))
                                @for ($i = 0; $i < $row->depth; ++$i)
                                    {!! '&mdash;' !!}
                                @endfor
                            @endif

                            {{ $row->getTitle($locale) }}

                            @if ($row->getTitle($locale) && count(config('app.locales')) > 1 && method_exists($row, 'getViewLink') && !empty($row->getViewLink($locale)))
                                <a target="_blank" href="{{ $row->getViewLink($locale) }}"><i class="fa fa-external-link"></i></a>
                            @endif
                        </td>
                    @endforeach

                    @include('admin.template.partials.datatable-tbody', ['row' => $row])
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
