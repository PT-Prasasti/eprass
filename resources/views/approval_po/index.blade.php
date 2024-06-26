<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    <b>
                        List PO Supplier
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
                <table id="table-purchase-order-supplier" class="table table-striped table-vcenter w-100" style="font-size:14px">
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
                        data: 'sales_order_id',
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
                                case 'Waiting Approval For Manager':
                                    badgeColor = `warning`;
                                    break;
                                case 'Sent PO':
                                    badgeColor = `primary`;
                                    break;
                                case 'Approved By Manager':
                                    badgeColor = `success`;
                                    break;
                                case 'Rejected By Manager':
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
                            html += `
                                <a href="{{ route('approval-po') }}/${row.id}/edit" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                            `;

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
        </script>
    </x-slot>
</x-app-layout>