@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('thead')
            <th>Başlık</th>
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <tr>
                    <td>
                        {{ $row->getTitle() }}
                    </td>

                    @include('admin.template.partials.datatable-tbody', ['row' => $row])
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
