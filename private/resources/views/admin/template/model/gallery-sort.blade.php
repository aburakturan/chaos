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
                    $traverse = function ($galleries) use (&$traverse, $row) {
                        foreach ($galleries as $gallery) {
                            if ($gallery->entity_id == $row->id) {
                                echo '<li class="dd-item" data-id="'.$gallery->id.'">';
                            } else {
                                echo '<li class="dd-item hidden" data-id="'.$gallery->id.'">';
                            }

                            echo '<div class="dd-handle"><img src="'.$gallery->getGalleryImageByTemplate('thumbnail').'"></div>';

                            if (count($gallery->children) > 0) {
                                echo '<ol class="dd-list">', $traverse($gallery->children), '</ol>';
                            }

                            echo '</li>';
                        }
                    };
                ?>

                <ol class="dd-list" style="margin-bottom:30px">
                    {!! $traverse($galleries) !!}
                </ol>
            </div>

            <form class="validate-form" action="{{ route('admin.'.$modelMeta->name.'.gallery-rebuild-tree', $row) }}" method="post">
                {{ method_field('PUT') }}

                <textarea name="nestable_list" class="nestable-list-text" style="display: none;"></textarea>

                @include('admin.template.components.form.save')
            </form>
        @endslot
    @endcomponent

@endsection