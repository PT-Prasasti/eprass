<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>Price List : {{ $so->id }}</b></h4>
            </div>
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12" id="viewTable">
                            <table class="table table-bordered table-vcenter js-dataTable-simple"
                                style="font-size:10px">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Item Description</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Supplier</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">DT Production</th>
                                        <th class="text-center">Delivery Time</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Shipping Fee</th>
                                        <th class="text-center">Profit</th>
                                        <th class="text-center">Total</th>
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

    <x-slot name="js">
        <script>
            $(document).ready(function() {

            })

            function dataTable(so) {
                $('#viewTable').html('')
                $('#viewTable').html(`
                    <table class="table table-bordered table-vcenter js-dataTable-simple"
                        style="font-size:10px">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Item Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">DT Production</th>
                                <th class="text-center">Delivery Time</th>
                                <th class="text-center">Currency</th>
                                <th class="text-center">Shipping Fee</th>
                                <th class="text-center">Profit</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                    </table>
                `)
                const table = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.product_lists') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "so": so
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: '8%',
                            className: 'text-center'
                        },

                    ],
                    "language ": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                })
                table.on('draw.dt', function() {
                    totalRows = table.rows().count();
                });
            }
        </script>
    </x-slot>
</x-app-layout>
