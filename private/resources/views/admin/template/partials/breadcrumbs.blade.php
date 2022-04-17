@if ($breadcrumbs)
    <div class="page-bar">
        <ul class="page-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}">{{ strip_tags($breadcrumb->title) }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                @else
                    <li class="active">{{ strip_tags($breadcrumb->title) }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif