<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    <b>
                        List PO Supplierr
                    </b>
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <span class="d-block">
                                {{ $loop->iteration }}. {{ $error }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-content block-content-full table-responsive">
                <table id="table-purchase-order-supplier" class="table table-striped table-vcenter w-100"
                    style="font-size:14px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">SO Number</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div hidden>
        <form id="form-delete" action="" method="POST">
            @csrf
            @method('delete')
        </form>
    </div>

    <x-slot name="js">
        <script>
            const quotationTable = $('#table-purchase-order-supplier').DataTable({
                ajax: `{{ url()->full() }}`,
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                },
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: 'transaction_code',
                    },
                    {
                        data: 'sales_order.id',
                    },
                    {
                        data: 'supplier.company',
                    },
                    {
                        data: 'transaction_date',
                        className: 'text-center',
                    },
                    {
                        data: 'status',
                        className: 'text-left',
                        render: function(data, type, row, meta) {
                            var badgeColor = ``;
                            switch (row.status) {
                                case 'Waiting For Payment':
                                    badgeColor = `danger`;
                                    break;
                                default:
                                    badgeColor = `warning`;
                            }

                            return `<span class="badge badge-${badgeColor}">${row.status}</span>`;
                        },
                    },
                    {
                        className: 'text-center text-nowrap',
                        render: function(data, type, row, meta) {
                            var html = ``;
                            console.log(row.status);
                            switch (row.status) {
                                case 'Send PO':
                                    html += `
                                    <a id="print" href="{{ route('purchase-order-supplier') }}/${row.id}/print" class="btn btn-sm btn-success" target="_blank" data-toggle="tooltip" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a> |
                                `;

                            html += `
                                <a href="{{ route('purchase-order-supplier') }}/${row.id}/edit" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                            `;

                            html += `
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete>
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            `;
                                    break;
                                case 'Rejected By Manager':
                                    html += `
                                    <a href="javascript:;" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a> |
                                `;
                                html += `
                                <a href="{{ route('purchase-order-supplier') }}/${row.id}/edit" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                            `;

                            html += `
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete>
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            `;
                                break;

                                default:

                            html += `
                                    <a href="javascript:;" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a> |
                                `;

                            html += `
                                <a href="javascript:;" class="btn btn-sm btn-dark" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                            `;

                            html += `
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete>
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            `;
                            }
                          

                            return `
                                ${html}
                            `
                        },
                    }
                ],
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                },
            });

            $(document).on('click', `[button-delete]`, function() {
                const row = $(this).closest('tr');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#form-delete`).attr('action',
                            `{{ route('purchase-order-supplier') }}/${row.data('id')}`);

                        $(`#form-delete`).submit();
                    }
                })
            });

            $(document).on('click', $('#print'), function() {
                console.log('a');
                window.location.reload();
            });
        </script>
    </x-slot>
</x-app-layout>
