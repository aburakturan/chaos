@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('thead')
            <th>İsim</th>
            @foreach(config('app.locales') as $locale => $localeMeta)
                <th>İçerik <span class="locale-filter">- {{ $localeMeta['label'] }}</span></th>
            @endforeach
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <tr>
                    <td>
                        {{ $row->getName() }}
                    </td>
                    @foreach(config('app.locales') as $locale => $localeMeta)
                        <td>
                            {{ $row->getExcerpt(200, $locale) }}
                        </td>
                    @endforeach

                    @include('admin.template.partials.datatable-tbody', ['row' => $row])
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
