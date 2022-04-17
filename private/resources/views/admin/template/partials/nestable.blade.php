<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold">
                Yeniden sırala
                @if ($maxDepth > 1) ve alt-üst öğeleri yeniden belirle @endif
            </span>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>
</div>