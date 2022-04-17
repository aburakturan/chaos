@extends('admin.template.master')

@include('admin.template.components.nestable', [
    'maxDepth' => (isset($maxDepth) ? $maxDepth : 5)
])

@section('content')

    @include('admin.template.components.buttons.page-index')

    @component('admin.template.partials.nestable')
        @slot('tbody')
            <div class="dd nestable-list">
                <?php
                $traverse = function ($rows) use (&$traverse) {
                    foreach ($rows as $row) {
                        echo '<li class="dd-item" data-id="'.$row->id.'">',
                            '<div class="dd-handle">'.(method_exists($row, 'getUniqueTitle') ? $row->getUniqueTitle() : $row->getTitle()).'</div>';

                        if ($row->children) {
                            echo '<ol class="dd-list">', $traverse($row->children), '</ol>';
                        }

                        echo '</li>';
                    }
                };
                ?>

                <ol class="dd-list" style="margin-bottom:30px">
                    {!! $traverse($rows) !!}
                </ol>
            </div>

            <form class="validate-form" action="{{ route('admin.'.$modelMeta->name.'.rebuild-tree') }}" method="post">
                {{ method_field('PUT') }}

                <textarea name="nestable_list" class="nestable-list-text" style="display: none;"></textarea>

                @include('admin.template.components.form.save')
            </form>
        @endslot
    @endcomponent

@endsection