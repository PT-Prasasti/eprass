<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    <b>
                        List Cloud
                    </b>
                </h4>
            </div>
            <div class="col-md-6 text-right">
                <a type="button" href="{{ route('cloud.create') }}" class="btn btn-primary mr-5 mb-5">
                    <i class="fa fa-upload mr-5"></i>Upload Document
                </a>
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
                <table id="table-cloud" class="table table-striped table-vcenter w-100" style="font-size:14px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Customer</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">QRCODE</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
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

    <div class="modal fade" id="modal-qr" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-qr" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">PO Customer : 0001/POC/XII/23</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content text-center">
                        <img src="../assets/qrcode.png" width="300">
                    </div>
                </div>
                <div class="modal-footer mt-5">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary" id="btnPrint" target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            const cloudTable = $('#table-cloud').DataTable({
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
                        data: 'kode_khusus',
                        className: "text-center",
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `${row.customer_name} - ${row.company_name}`;
                        },
                        className: "text-center"
                    },
                    {
                        data: 'sales_name',
                        className: "text-center"
                    },
                    {
                        data: 'date',
                        className: 'text-center',
                    },
                    {
                        className: 'text-center text-nowrap',
                        render: function(data, type, row) {
                            return `<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-qr" data-pocid="${row.po_customer}" data-kodekhusus="${row.kode_khusus}" data-uuid="${row.uuid}" title="QRCODE">
                                    <i class="fa fa-qrcode"></i>
                                    </button>`;
                        }
                    },
                    {
                        className: 'text-center text-nowrap',
                        render: function(data, type, row, meta) {
                            var html = `
                                <a href="{{ route('purchase-order-customer') }}/${row.id}/view" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> | <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete>
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                            `;
                            return `${html}`
                        },
                    }
                ],
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                },
            });

            $(document).on('click', `[data-target="#modal-qr"]`, function() {
                const pocId = $(this).data('pocid');
                const kodeKhusus = $(this).data('kodekhusus');
                const uuid = $(this).data('uuid');
                
                const filename = `qr_code_${uuid}.png`;
                const qrCodeImageUrl = `{{ url('/') }}/storage/cloud-storage/qr/${filename}`;
                
                $('#modal-qr').find('.block-title').text(`PO Customer: ${kodeKhusus}`);
                $('#modal-qr').find('.block-content img').attr('src', qrCodeImageUrl);

                const printUrl = `{{ url('/cloud/') }}/${uuid}/print`;
                console.log(printUrl);
                $('#btnPrint').attr('href', printUrl);

                $('#modal-qr').modal('show');
            });

            $(document).on('click', `[button-delete]`, function() {
                const row = $(this).closest('tr');
                Swal.fire({
                    title: 'Are you sure?'
                    , text: "You won't be able to revert this!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#form-delete`).attr('action'
                            , `{{ route('cloud') }}/${row.data('id')}`);

                        $(`#form-delete`).submit();
                    }
                })
            });

        </script>
    </x-slot>
</x-app-layout>