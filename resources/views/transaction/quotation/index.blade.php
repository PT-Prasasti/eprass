<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Approval Sales Order</b></h4>
            </div>
            {{-- <div class="col-md-6 text-right">
                <div class="push">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grade</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    1-50 %
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    51 - 100%
                                </a>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Waiting
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    SO Ready
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Waiting Approval
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Done
                                </a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary">Customer</button>
                    </div>
                </div>
            </div> --}}
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
                <table id="table-quotation" class="table table-striped table-vcenter w-100" style="font-size:14px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Quotation Number</th>
                            <th class="text-center">SO Number</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Valid Until</th>
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
            const quotationTable = $('#table-quotation').DataTable({
                ajax: `{{ route('transaction.quotation.data') }}`,
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
                        data: 'quotation_code',
                    },
                    {
                        data: 'sales_order.id',
                    },
                    {
                        data: 'sales_order.inquiry.visit.customer.company',
                    },
                    {
                        data: 'sales_order.due_date',
                        className: 'text-center',
                    },
                    {
                        data: 'sales_order.inquiry.grade',
                        className: 'text-right',
                        render: function(data, type, row, meta) {
                            return `${row.sales_order.inquiry.grade} %`;
                        },
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'due_date',
                        className: 'text-center',
                    },
                    {
                        data: 'status',
                        render: function(data, type, row, meta) {
                            return `
                                <a href="{{ route('transaction.quotation') }}/${row.id}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete>
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            `
                        },
                    }
                ],
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                },
                rowCallback: function(row, data, index) {
                    if (data.is_warning === true) {
                        $(row).addClass('bg-danger text-white');
                    }
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
                            `{{ route('transaction.quotation') }}/${row.data('id')}`);

                        $(`#form-delete`).submit();
                    }
                })
            });
        </script>
    </x-slot>
</x-app-layout>
