@extends('admin.template.model.index')

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.datatable')
        @slot('title', 'Geçiş Yapabileceğiniz Kullanıcılar')

        @slot('thead')
            <th>Ad Soyad</th>
            <th>E-posta</th>
            <th>Rol</th>
            <th>Geçiş</th>
        @endslot

        @slot('tbody')
            @foreach ($rows as $row)
                <tr>
                    <td class="col-xs-3">
                        {{ $row->getTitle() }}
                    </td>
                    <td class="col-xs-3">
                        {{ $row->getEmail() }}
                    </td>
                    <td class="col-xs-3">
                        {{ $row->roles->pluck('title')->implode(',') }}
                    </td>
                    <td class="col-xs-1">
                        <a href="{{ route('admin.user-switch.start', ['id' => $row->id]) }}" class="btn btn-sm red-thunderbird" data-toggle="confirmation" data-original-title="Geçmek istediğinizden emin misiniz?" data-btn-ok-label="Evet" data-btn-cancel-label="Hayır" data-placement="left">
                            <i class="fa fa-exchange"></i> Geçiş Yap
                        </a>
                    </td>
                </tr>
            @endforeach
        @endslot
    @endcomponent

@endsection
