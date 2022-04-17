@extends('admin.template.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-trash font-red"></i>
                        <span class="caption-subject font-red">{{ $modelMeta->deleteTitle }} Kalıcı Olarak Sil</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="
                        @if (Route::has('admin.'.$modelMeta->name.'.hard-delete'))
                            {{ route('admin.'.$modelMeta->name.'.hard-delete', $row) }}
                        @else
                            {{ route('admin.'.$modelMeta->name.'.destroy', $row) }}
                        @endif
                    " method="post">
                        {{ method_field('DELETE') }}

                        <div class="form-body">
                            <h4 class="text-center">
                                <a class="font-red" href="{{ $row->getEditLink() }}">
                                    <strong>"{{ $row->getTitle() }}"</strong>
                                </a>
                                <br><br>
                                Kalıcı olarak silmek istediğinizden emin misiniz?
                            </h4>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn red">Evet, Kalıcı Olarak Sil</button>
                                    @if (Route::has('admin.'.$modelMeta->name.'.edit'))
                                        <a class="btn grey-mint" href="{{ route('admin.'.$modelMeta->name.'.edit', $row) }}">Hayır, İçeriğe Dön</a>
                                    @elseif (Route::has('admin.'.$modelMeta->name.'.show'))
                                        <a class="btn grey-mint" href="{{ route('admin.'.$modelMeta->name.'.show', $row) }}">Hayır, İçeriğe Dön</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>

@endsection