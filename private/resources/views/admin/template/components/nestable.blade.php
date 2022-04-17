{{-- Load Css Files --}}
@push('head-page-level')
<link href="{{ asset('admin-assets/global/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
<style>
    .dd-handle {height: auto;}
</style>
@endpush

{{-- Load JS Files --}}
@push('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>

{{-- Init Library --}}
<script>
    $(document).ready(function() {
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $('.nestable-list').nestable({
                group: 1,
                maxDepth: {{ $maxDepth ?? 5 }}
        }).on('change', updateOutput);

        updateOutput($('.nestable-list').data('output', $('.nestable-list-text')));
    });
</script>
@endpush