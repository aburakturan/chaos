@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('thead')
            <th>İsim Soyisim</th>
            <th>Email</th>
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <tr>
                    <td>
                        {{ $row->getFullName() }}
                    </td>
                    <td>
                        {{ $row->getEmail() }}
                    </td>

                    @include('admin.template.partials.datatable-tbody', ['row' => $row])
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
