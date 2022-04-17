@extends('admin.template.master')

@section('content')

    @include('admin.template.components.buttons.page-edit')

    @component('admin.template.partials.datatable')
        @slot('thead')
            <th class="col-xs-1">Alan</th>
            <th>Eski Değer</th>
            <th>Yeni Değer</th>
        @endslot

        @slot('tfoot')
            <td colspan="3">
                <div>
                    <strong>Created At:</strong> {{ $row->created_at->diffForHumans() }} | <strong>Datetime:</strong> {{ $row->created_at }}
                </div>

                <div style="margin-top: 10px">
                    @if (!is_null($row->subject_type))
                        <strong>Subject Type:</strong> {{ $row->subject_type }}
                    @endif
                    @if (!is_null($row->subject_type) && !is_null($row->subject_id))
                        |
                    @endif
                    @if (!is_null($row->subject_id))
                        <strong>Subject Id:</strong> {{ $row->subject_id }}
                    @endif
                </div>

                <div style="margin-top: 10px">
                    @if (!is_null($row->causer_type))
                        <strong>Causer Type:</strong> {{ $row->causer_type }}
                    @endif
                    @if (!is_null($row->causer_type) && !is_null($row->causer_id))
                        |
                    @endif
                    @if (!is_null($row->causer_type))
                        <strong>Causer Id:</strong> {{ $row->causer_id }}
                    @endif
                </div>
            </td>
        @endslot

        @slot('tbody')
            @foreach ($row->changes() as $changeKey => $changes)
                @if ($changeKey == 'attributes')
                    @foreach ($changes as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>
                                @if (isset($row->changes()['old']))
                                    {{ $row->changes()['old'][$key] ?? '' }}
                                @endif
                            </td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        @endslot
    @endcomponent

@endsection