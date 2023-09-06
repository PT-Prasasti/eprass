<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Inquiry</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <div class="push">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grade</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" onclick="gradeData('1','50')" role="button">
                                    1-50 %
                                </a>
                                <a class="dropdown-item" onclick="gradeData('51','100')" role="button">
                                    51 - 100%
                                </a>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" onclick="statusData('waiting')" role="button">
                                    Waiting
                                </a>
                                <a class="dropdown-item" onclick="statusData('so ready')" role="button">
                                    SO Ready
                                </a>
                                <a class="dropdown-item" onclick="statusData('waiting approval')" role="button">
                                    Waiting Approval
                                </a>
                                <a class="dropdown-item" onclick="statusData('done')" role="button">
                                    Done
                                </a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-slideup">Customer</button>
                        @if(auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin'))
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-slideup2">Sales</button>
                        @endif
                    </div>
                    @if(auth()->user()->hasRole('sales') || auth()->user()->hasRole('superadmin'))
                    <a type="button" href="{{ route('crm.inquiry.add') }}" class="btn btn-info min-width-125"><i class="fa fa-plus mr-2"></i>NEW INQUIRY</a>
                    @endif
                </div>
            </div>
        </div>
        

        <div class="block block-rounded">
            <div class="block-content block-content-full" id="viewTable">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin'))
                            <th class="text-center">Sales Name</th>
                            @endif
                            <th class="text-center">SO Number</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Status Visit</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <label class="col-12">Status Visit</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="">
                                        <option value="0" selected disabled>Please select</option>
                                        <option>Loading</option>
                                        <option>Finish</option>
                                        <option>Cancel</option>
                                        <option>Reschedule</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label class="col-12">Note</label>
                            <div class="col-12">
                                <textarea class="form-control" name="" rows="6"></textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-danger" data-dismiss="modal">
                            <i class="fa fa-trash"></i> Close
                        </button>
                        <button type="button" class="btn btn-alt-primary" data-dismiss="modal">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-slideup" aria-hidden="true">
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

        @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin'))
        <div class="modal fade" id="modal-slideup2" tabindex="-1" role="dialog" aria-labelledby="modal-slideup" aria-hidden="true">
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
        @endif

    </div>

    <x-slot name="js">

    @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin'))
    
    <script>
        $(document).ready(function() {
            dataTable()
        })

        function dataTable()
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "sales"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function gradeData(value1, value2)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-grade') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value1": value1,
                        "value2": value2
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "sales"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function statusData(value)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-status') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value": value
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "sales"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function searchCustomer()
        {
            customerData($('#customer-search').val())
            $('#modal-slideup').modal('toggle')
        }

        function customerData(value)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-customer') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value": value
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "sales"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function delete_data(id)
        {
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
                    link.href = 'inquiry/delete/'+id;
                    link.click();
                }
            })
        }
    </script>
    <script>
        function searchSales()
        {
            salesData($('#sales-search').val())
            $('#modal-slideup2').modal('toggle')
        }

        function salesData(value)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Sales Name</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-sales') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value": value
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "sales"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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
    </script>   
    @else 

    <script>
        $(document).ready(function() {
            dataTable()
        })

        function dataTable()
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function gradeData(value1, value2)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-grade') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value1": value1,
                        "value2": value2
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function statusData(value)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-status') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value": value
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function searchCustomer()
        {
            customerData($('#customer-search').val())
            $('#modal-slideup').modal('toggle')
        }

        function customerData(value)
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">ID Inquiry</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">SO Number</th>
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
                    "url": "{{ route('crm.inquiry.data-customer') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "value": value
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id_visit"
                    },
                    {
                        data: "id_inquiry"
                    },
                    {
                        data: "customer"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "grade",
                        className: "text-center",
                        render: function(data) {
                            return `${data}%`
                        }
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "so_number"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `@if(auth()->user()->hasRole('superadmin'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @elseif(auth()->user()->hasRole('admin_sales'))
                                    <a href="inquiry/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @elseif(auth()->user()->hasRole('sales'))
                                    <a href="inquiry/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Inquiry">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Inquiry">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif`
                        }
                    },
                ],
                "rowCallback": function (row, data, index) {
                    if(data.warning === true) {
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

        function delete_data(id)
        {
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
                    link.href = 'inquiry/delete/'+id;
                    link.click();
                }
            })
        }
    </script>
    @endif

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

