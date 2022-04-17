@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('thead')
            <th>Başlık yada Model Adı</th>
            <th>Model</th>
            <th class="col-xs-1">Aksiyon</th>
            <th class="col-xs-2">Neden Olan</th>
            <th class="col-xs-2">Tarih</th>
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <?php $class = get_class($row->subject); ?>
                <tr>
                    <td>
                        <span class="popovers" data-trigger="hover" data-content="{{ $class }}" data-original-title="Model Hakkında" data-container="body">
                            {{ $row->getTitle() }}
                        </span>
                    </td>
                    <td>{{ class_basename($class) }}</td>
                    <td>{{ $row->description }}</td>
                    <td>
                        @if (!is_null($row->causer))
                            {{ $row->causer->getTitle() }}
                        @else
                            <strong>ROOT</strong>
                        @endif
                    </td>
                    <td>{{ $row->created_at }}</td>

                    @include('admin.template.partials.datatable-tbody', ['row' => $row])
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
