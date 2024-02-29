<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    <b>
                        List Payment Request
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
            <div class="block-content block-content-full table-responsive" id="viewTable">
                <table id="table-payment-request" class="table table-striped table-vcenter w-100" style="font-size:14px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Kode Payment Request</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Position</th>
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
            $(document).ready(function() {
                dataTable();
            });

            function dataTable() {
                $('#viewTable').html(``);
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple w-100" style="font-size:14px" id="table-payment-request">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Kode Payment Request</th>
                                                    <th class="text-center">Subject</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                                                </tr>
                                            </thead>
                                        </table>`);
                $('#table-payment-request').DataTable({
                    processing: true, 
                    serverSide: true, 
                    responsive: true, 
                    "paging": true, 
                    "order": [
                        [1, "desc"]
                    ], 
                    ajax: {
                        "url": "{{ route('payment-request.exim') }}", 
                        "type": "GET", 
                        "data": {
                            "_token": "{{ csrf_token() }}"
                        },
                    }, 
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        }, 
                        {
                            data: "id",
                            className: "text-center"
                        }, 
                        {
                            data: "subject",
                            className: "text-center"
                        },
                        {
                            data: "submission_date",
                            className: "text-center"
                        },
                        {
                            data: 'status', 
                            className: 'text-center',
                            render: function(data, type, row, meta) {
                                var badgeColor = ``;
                                switch (row.status) {
                                    case 'Waiting For Approval':
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

                                html += `
                                <a href="{{ route('payment-request.exim') }}/${row.uuid}/view" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                            `;

                                html += `
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" button-delete data-id="${row.uuid}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            `;

                                return `${html}`
                            }, 
                        }, 
                    ], 
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>'
                            , "next": '<i class="fa fa-angle-right"></i>'
                        },
                    }
                })
            }

            $(document).on('click', `[button-delete]`, function() {
                const row = $(this).data('id');
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
                        `{{ url()->full() }}/delete/${row}`);

                        $(`#form-delete`).submit();
                    }
                })
            });
        </script>
    </x-slot>
</x-app-layout>
