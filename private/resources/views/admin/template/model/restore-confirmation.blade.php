@extends('admin.template.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-trash font-green-jungle"></i>
                        <span class="caption-subject font-green-jungle">{{ $modelMeta->deleteTitle }} Geri Al</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{ route('admin.'.$modelMeta->name.'.restore', $row) }}" method="post">
                        {{ method_field('PUT') }}

                        <div class="form-body">
                            <h4 class="text-center">
                                <a class="font-green-jungle" href="{{ $row->getEditLink() }}">
                                    <strong>"{{ $row->getTitle() }}"</strong>
                                </a>
                                <br><br>
                                Geri almak istediğinizden emin misiniz?
                                <br><br>
                                <small>
                                    Eğer bu öğeyi geri alırsanız tekrar yayına girecektir.
                                </small>
                            </h4>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn green-jungle">Evet, Geri Al</button>

                                    @if (Route::has('admin.'.$modelMeta->name.'.edit'))
                                        <a class="btn grey-mint" href="{{ route('admin.'.$modelMeta->name.'.edit', $row) }}">Hayır, İçeriğe Dön</a>
                                    @elseif(Route::has('admin.'.$modelMeta->name.'.show'))
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