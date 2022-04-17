<div class="form-group" style="margin-bottom: 50px">
    <div class="mt-repeater">
        <h3>{{ $title ?? '' }}</h3>
        <div data-repeater-list="{{ $name ?? uniqid() }}">
            {!! $content !!}
        </div>
        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Ekle</a>
    </div>
</div>

{{-- Load JS Files --}}
@if ($includeScripts ?? false)
    @push('footer-page-level-plugins')
        <script src="{{ asset('admin-assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admin-assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.mt-repeater').each(function() {
                    var $repeater = $(this);

                    if ($repeater.data('hasRepeater')) {
                        return;
                    }

                    $repeater.repeater({
                        show: function() {
                            $(this).slideDown();
                        },
                        hide: function(deleteElement) {
                            if (confirm('Silmek istediğinizden emin misiniz?')) {
                                $(this).slideUp(deleteElement);
                            }
                        },
                        ready: function(setIndexes) {}
                    });

                    $repeater.data('hasRepeater', true);

                    $repeater.find('[data-repeater-list]').sortable();
                });
            })
        </script>
    @endpush
@endif
