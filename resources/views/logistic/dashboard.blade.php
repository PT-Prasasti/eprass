<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-xl-6">
                <div class="block">
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-xl-6">
                                <h4><b>List PO Tracking</b></h4>
                            </div>
                            <div class="col-md-12">
                                <div id="viewTableTracking" class="table-responsive">
                                    <table class="table table-striped table-vcenter" style="font-size:13px" id="tablePoTracking">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">POS Number</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Estimate Date</th>
                                                <th class="text-center"><i class="fa fa-ellipsis-h"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="block">
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-xl-6">
                                <h4><b>List Stock</b></h4>
                            </div>
                            <div class="col-md-12">
                                <div id="viewTableStock" class="table-responsive">
                                    <table class="table table-striped table-vcenter" style="font-size:13px" id="tableStock">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">PO Customer</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="block">
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-xl-6">
                                <h4><b>List Delivery Schedule</b></h4>
                            </div>
                            <div class="col-md-12">
                                <div id="viewTableDO" class="table-responsive">
                                    <table class="table table-striped table-vcenter" style="font-size:13px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">PO Cust Number</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Due Date</th>
                                                <th class="text-center">Schedule Date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="js">
        <script>
            $(document).ready(function() {
                trackingTable();
                stockTable();
                doTable();
            });

            function trackingTable() {
                $('#viewTableTracking').html(``)
                $('#viewTableTracking').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="tablePoTracking">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                                                <th class="text-center">POS Number</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Estimate Date</th>
                                                <th class="text-center"><i class="fa fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                </table>`)
                $('#tablePoTracking').DataTable({
                    processing: true
                    , serverSide: true
                    , responsive: true
                    , "paging": true
                    , "order": [
                        [0, "asc"]
                    ]
                    , ajax: {
                        url: "{{ route('logistic.data') }}"
                        , type: "POST"
                        , data: {
                            "_token": "{{ csrf_token() }}"
                        }
                    , }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'pos_number'
                            , orderable: false
                            , className: "text-center"
                        },
                        {
                            data: 'status'
                            , orderable: false
                            , className: "text-center"
                            , render: function(data) {
                                var badgeClass = '';
                                switch (data) {
                                    case 'Shipping to Jakarta':
                                        badgeClass = 'badge-warning';
                                        break;
                                    case 'Custom Process':
                                        badgeClass = 'badge-primary';
                                        break;
                                    case 'Shipping to PRASASTI':
                                        badgeClass = 'badge-secondary';
                                        break;
                                    case 'Done':
                                        badgeClass = 'badge-success';
                                        break;
                                    default:
                                        badgeClass = 'badge-danger';
                                        break;
                                }
                                return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                            }
                        },
                        {
                            data: 'estimate_date'
                            , orderable: false
                            , className: "text-center"
                        }
                        , {
                            data: "uuid"
                            , orderable: false
                            , className: "text-center"
                            , render: function(data) {
                                return `<a type="button" href="/po-tracking/${data}/view" class="btn btn-sm btn-primary" data-toggle="tooltip"><i class="fa fa-file"></i></a>`;
                            }
                        }
                    ]
                    , "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>'
                            , "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                    , pageLength: 5
                    , lengthChange: false
                    , searching: false
                })
            }

            function stockTable() {
                $('#viewTableStock').html(``)
                $('#viewTableStock').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="tableStock">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">PO Customer</th>
                        </tr>
                    </thead>
                </table>`)
                $('#tableStock').DataTable({
                    processing: true
                    , serverSide: true
                    , responsive: true
                    , "paging": true
                    , "order": [
                        [0, "asc"]
                    ]
                    , ajax: {
                        url: "{{ route('logistic.data-stock') }}"
                        , type: "POST"
                        , data: {
                            "_token": "{{ csrf_token() }}"
                        }
                    , }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , searchable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'item_name'
                            , orderable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'qty'
                            , orderable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'po_customer'
                            , className: "text-center"
                        }
                    ]
                    , "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>'
                            , "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                    , pageLength: 5
                    , lengthChange: false
                    , searching: false
                })
            }

            function doTable() {
                $('#viewTableDO').html(``)
                $('#viewTableDO').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="tableDeliveryOrder">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                                                <th class="text-center">PO Cust Number</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Due Date</th>
                                                <th class="text-center">Schedule Date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center"><i class="fa fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                </table>`)
                $('#tableDeliveryOrder').DataTable({
                    processing: true
                    , serverSide: true
                    , responsive: true
                    , "paging": true
                    , "order": [
                        [0, "asc"]
                    ]
                    , ajax: {
                        url: "{{ route('logistic.data-do') }}"
                        , type: "POST"
                        , data: {
                            "_token": "{{ csrf_token() }}"
                        }
                    , }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'po_customer_id'
                            , orderable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'customer_name'
                            , orderable: false
                            , className: "text-center"
                        },
                        {
                            data: 'due_date'
                            , orderable: false
                            , className: "text-center"
                        }
                        , {
                            data: 'schedule_date'
                            , orderable: false
                            , className: "text-center"
                        },
                        {
                            data: 'status'
                            , orderable: false
                            , className: "text-center"
                            , render: function(data) {
                                var badgeClass = '';
                                switch (data) {
                                    case 'On Progress':
                                        badgeClass = 'badge-warning';
                                        break;
                                    case 'Done':
                                        badgeClass = 'badge-success';
                                        break;
                                    default:
                                        badgeClass = 'badge-danger';
                                        break;
                                }
                                return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                            }
                        }
                        , {
                            data: "id"
                            , orderable: false
                            , className: "text-center"
                            , render: function(data) {
                                return `<a type="button" href="/logistic/delivery-order/${data}/view" class="btn btn-sm btn-primary" data-toggle="tooltip"><i class="fa fa-file"></i></a>`;
                            }
                        }
                    ]
                    , "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>'
                            , "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                    , pageLength: 5
                    , lengthChange: false
                    , searching: false
                })
            }

        </script>
    </x-slot>

</x-app-layout>
