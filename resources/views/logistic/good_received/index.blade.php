<x-app-layout>
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    <h4><b>List Check Mark</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <a type="button" class="btn btn-primary mr-5 mb-5" href="{{ route('logistic.good_received.add') }}">
                        <i class="fa fa-plus mr-5"></i>Add Data
                    </a>
                </div>
            </div>


            <div class="block block-rounded">
                <div class="block-content block-content-full" id="dt-container">
                    <table id="dt-data" class="table table-striped table-vcenter js-dataTable-simple"
                        style="font-size:13px">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">PO Supp Number</th>
                                <th class="text-center">Supp Name</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                dataTable();
            });

            function dataTable() {
                $('#dt-container').html('');

                $('#dt-container').html(`
                    <table id="dt-data" class="table table-striped table-vcenter js-dataTable-simple"
                            style="font-size:13px">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">PO Supp Number</th>
                                <th class="text-center">Supp Name</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                            </tr>
                        </thead>
                    </table>
                `);

                $('#dt-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('logistic.good_received.data') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'purchase_order_supplier_number',
                            name: 'purchase_order_supplier_number',
                            className: 'text-center'
                        },
                        {
                            data: 'supplier_name',
                            name: 'supplier_name',
                            className: 'text-center'
                        },
                        {
                            data: 'date',
                            name: 'date',
                            className: 'text-center'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <a type="button" href="form_app.php" class="btn btn-sm btn-primary" data-toggle="tooltip">
                                        <i class="fa fa-file"></i>
                                    </a>
                                `;
                            }
                        },
                    ]
                });
            }
        </script>
    </x-slot>
</x-app-layout>
