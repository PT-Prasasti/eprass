<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Sales Order</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <div class="push">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grade</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" onclick="gradeData('1','50')" role="button">
                                    1-50 %
                                </a>
                                <a class="dropdown-item" onclick="gradeData('51','100')" role="button">
                                    51 - 100%
                                </a>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" onclick="statusData('waiting')" role="button">
                                    Waiting
                                </a>
                                <a class="dropdown-item" onclick="statusData('on process')" role="button">
                                    On Process
                                </a>
                                <a class="dropdown-item" onclick="statusData('waiting approval')" role="button">
                                    Waiting Approval
                                </a>
                                <a class="dropdown-item" onclick="statusData('done')" role="button">
                                    Done
                                </a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal-slideup">Customer</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal-slideup2">Sales</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full" id="viewTable">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px"
                    id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="modal-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Cari berdasarkan customer</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label>Customer</label>
                            <input type="text" class="form-control" id="customer-search">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="searchCustomer()" class="btn btn-alt-primary">
                        <i class="fa fa-check"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-slideup2" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Cari berdasarkan sales</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label>Sales</label>
                            <input type="text" class="form-control" id="sales-search">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="searchSales()" class="btn btn-alt-primary">
                        <i class="fa fa-check"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="js">

        <script>
            $(document).ready(function() {
                dataTable()
            })

            function dataTable() {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.data') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}"
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "id_so"
                        },
                        {
                            data: "id_inquiry"
                        },
                        {
                            data: "customer"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "grade",
                            className: "text-center",
                        },
                        {
                            data: "sales"
                        },
                        {
                            data: "status",
                            render: function(data) {
                                if (data == 'ON PROCESS') {
                                    return 'ON PROGRESS'
                                } else {
                                    return data
                                }
                            }
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `@if (auth()->user()->hasRole('manager'))
                                    <a href="sales-order/open/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('purchasing') ||
                                            auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Price">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                    <a href="sales-order/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Sourcing Item">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Sourcing Item">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                            }
                        },
                    ],
                    "rowCallback": function(row, data, index) {
                        if (data.warning === true) {
                            $(row).addClass('bg-danger text-white');
                        }
                    },
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                });
            }

            function gradeData(value1, value2) {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.data-grade') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "value1": value1,
                            "value2": value2,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "id_so"
                        },
                        {
                            data: "id_inquiry"
                        },
                        {
                            data: "customer"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "grade",
                            className: "text-center",
                        },
                        {
                            data: "sales"
                        },
                        {
                            data: "status",
                            render: function(data) {
                                if (data == 'ON PROCESS') {
                                    return 'ON PROGRESS'
                                } else {
                                    return data
                                }
                            }
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `@if (auth()->user()->hasRole('manager'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('purchasing') ||
                                            auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Price">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                    <a href="sales-order/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Sourcing Item">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Sourcing Item">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                            }
                        },
                    ],
                    "rowCallback": function(row, data, index) {
                        if (data.warning === true) {
                            $(row).addClass('bg-danger text-white');
                        }
                    },
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                });
            }

            function statusData(value) {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.data-status') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "value": value,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "id_so"
                        },
                        {
                            data: "id_inquiry"
                        },
                        {
                            data: "customer"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "grade",
                            className: "text-center",
                        },
                        {
                            data: "sales"
                        },
                        {
                            data: "status",
                            render: function(data) {
                                if (data == 'ON PROCESS') {
                                    return 'ON PROGRESS'
                                } else {
                                    return data
                                }
                            }
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `@if (auth()->user()->hasRole('manager'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('purchasing') ||
                                            auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Price">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                    <a href="sales-order/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Sourcing Item">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Sourcing Item">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                            }
                        },
                    ],
                    "rowCallback": function(row, data, index) {
                        if (data.warning === true) {
                            $(row).addClass('bg-danger text-white');
                        }
                    },
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                });
            }

            function searchCustomer() {
                customerData($('#customer-search').val())
                $('#modal-slideup').modal('toggle')
            }

            function customerData(value) {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.data-customer') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "value": value,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "id_so"
                        },
                        {
                            data: "id_inquiry"
                        },
                        {
                            data: "customer"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "grade",
                            className: "text-center",
                        },
                        {
                            data: "sales"
                        },
                        {
                            data: "status",
                            render: function(data) {
                                if (data == 'ON PROCESS') {
                                    return 'ON PROGRESS'
                                } else {
                                    return data
                                }
                            }
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `@if (auth()->user()->hasRole('manager'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('purchasing') ||
                                            auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Price">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                    <a href="sales-order/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Sourcing Item">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Sourcing Item">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                            }
                        },
                    ],
                    "rowCallback": function(row, data, index) {
                        if (data.warning === true) {
                            $(row).addClass('bg-danger text-white');
                        }
                    },
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                });
            }

            function searchSales() {
                salesData($('#sales-search').val())
                $('#modal-slideup2').modal('toggle')
            }

            function salesData(value) {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Sales Order</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.data-sales') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "value": value,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "id_so"
                        },
                        {
                            data: "id_inquiry"
                        },
                        {
                            data: "customer"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "grade",
                            className: "text-center",
                        },
                        {
                            data: "sales"
                        },
                        {
                            data: "status",
                            render: function(data) {
                                if (data == 'ON PROCESS') {
                                    return 'ON PROGRESS'
                                } else {
                                    return data
                                }
                            }
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `@if (auth()->user()->hasRole('manager'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Sourcing Item">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('purchasing') ||
                                            auth()->user()->hasRole('superadmin'))
                                    <a href="sales-order/view/${data}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Price">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                    <a href="sales-order/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Sourcing Item">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Sourcing Item">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                            }
                        },
                    ],
                    "rowCallback": function(row, data, index) {
                        if (data.warning === true) {
                            $(row).addClass('bg-danger text-white');
                        }
                    },
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                });
            }

            function delete_data(id) {
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
                        const link = document.createElement('a');
                        link.href = 'sales-order/delete/' + id;
                        link.click();
                    }
                })
            }
        </script>

        @if (Session::has('success'))
            <script>
                toastr.success("{{ Session::get('success') }}", 'Success')
            </script>
        @endif

        @if (Session::has('delete'))
            <script>
                toastr.error("{{ Session::get('delete') }}", 'Success')
            </script>
        @endif

    </x-slot>

</x-app-layout>
