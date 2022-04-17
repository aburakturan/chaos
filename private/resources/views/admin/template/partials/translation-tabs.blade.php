<div class="tabbable tabbable-tabdrop">
    <ul class="nav nav-tabs locale-tabs">
        @foreach (config('app.locales') as $lang => $langMeta)
            <li class="@if ($loop->first) active @endif">
                <a href="#tab_{{ $id ?? 'lang' }}_{{ $lang }}" data-toggle="tab">
                    {{ $langMeta['label'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        {{ $content }}
    </div>
</div>