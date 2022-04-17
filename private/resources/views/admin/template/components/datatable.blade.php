{{-- Load Css Files --}}
@push('head-page-level')
<link href="{{ asset('admin-assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endpush

{{-- Load JS Files --}}
@push('footer-page-level-plugins')
<script src="{{ asset('admin-assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

{{-- Init Library --}}
<script>
    if ($('.datatable').length > 0) {
        $('.datatable').each(function() {
            var table = $(this),
                columns = table.attr('data-export-columns'),
                columnsSizes = table.attr('data-export-columns-sizes');

            if (columns !== undefined || columns.length === 0) {
                columns = columns.split(',');
            } else {
                columns = new Array();
            }

            if (columnsSizes !== undefined && columnsSizes.length > 0) {
                columnsSizes = columnsSizes.split(',').map(Function.prototype.call, String.prototype.trim).map(function(item) {
                    if (item == 'auto' || item == '*') {
                        return item;
                    }

                    return parseInt(item);
                })
            } else {
                columnsSizes = '';
            }

            var groupColumn = table.attr('data-group-column');

            var oTable = table.dataTable({
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    processing: "İşleniyor...",
                    search: "Ara:",
                    lengthMenu: "Sayfada _MENU_ Kayıt Göster",
                    info: "_TOTAL_ Kayıttan _START_ - _END_ Arası Kayıtlar",
                    infoEmpty: "Kayıt Yok",
                    infoFiltered: "( _MAX_ Kayıt İçerisinden Bulunan)",
                    infoPostFix: "",
                    zeroRecords: "Eşleşen Kayıt Bulunmadı",
                    emptyTable: "Henüz Kayıt Girilmedi",
                    paginate: {
                        first: "İlk",
                        previous: "Önceki",
                        next: "Sonraki",
                        last: "Son"
                    },
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    }
                },

                // setup buttons extentension: http://datatables.net/extensions/buttons/
                buttons: [
                    // {
                    //     extend: 'print',
                    //     className: 'btn dark btn-outline',
                    //     text: 'Yazdır',
                    //     exportOptions: {
                    //         columns: columns,
                    //     },
                    // },
                    {
                        extend: 'copy',
                        className: 'btn red btn-outline',
                        text: 'Kopyala',
                        exportOptions: {
                            columns: columns,
                        },
                    },
                    {
                        extend: 'pdf',
                        className: 'btn green btn-outline',
                        orientation: 'landscape',
                        // pageSize: 'A3',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 8;

                            doc.pageMargins = [10, 10];

                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.alignment = 'center';
                            doc.styles.tableHeader.margin = 3;

                            doc.styles.tableBodyOdd.margin = 3;
                            doc.styles.tableBodyEven.margin = 3;

                            if ($.isArray(columnsSizes)) {
                                doc.content[1].table.widths = columnsSizes;
                            } else {
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split(''); // auto full width
                            }
                        },
                        exportOptions: {
                            columns: columns,
                        },
                    },
                    {
                        extend: 'excel',
                        className: 'btn yellow btn-outline',
                        exportOptions: {
                            columns: columns,
                        },
                    },
                    {
                        extend: 'csv',
                        className: 'btn purple btn-outline',
                        exportOptions: {
                            columns: columns,
                        },
                    },
                ],

                // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
                rowReorder: {
                    selector: '.sortable',
                },

                order: groupColumn.length > 0 ? [[groupColumn, 'asc']] : '',

                drawCallback: function ( settings ) {
                    if (groupColumn.length > 0) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null;

                        api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="'+settings.aoColumns.length+'">'+group+'</td></tr>'
                                );

                                last = group;
                            }
                        } );
                    }
                },

                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "Tümü"] // change per page values here
                ],
                // set the initial value
                "pageLength": 20,

                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        });
    }
</script>
@endpush