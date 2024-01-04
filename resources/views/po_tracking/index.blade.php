<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List PO Tracking</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <div class="push">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
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
                        <button type="button" class="btn btn-primary">Supplier</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table id="table-po-tracking" class="table table-striped table-vcenter" style="font-size:13px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Supplier Name</th>
                            <!-- <th class="text-center">DD to Customer</th> -->
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

    <x-slot name="js">
        <script>
            const quotationTable = $('#table-po-tracking').DataTable({
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
                        data: 'purchase_order_suppliers.transaction_code',
                        className: "text-center",
                        render: function(data, type, row, meta) {
                            console.log(row);
                            return data;
                        }
                    },
                    {
                        data: 'purchase_order_suppliers.supplier.company',
                        className: "text-center",
                        render: function(data, type, row, meta) {
                            console.log(row);
                            return data;
                        }
                    },
                    {
                        data: 'purchase_order_suppliers.supplier.sales_representation',
                        className: "text-center",
                    },
                    // {
                    //     data: 'supplier.company',
                    // },
                    // {
                    //     data: 'transaction_date',
                    //     className: 'text-center',
                    // },
                    {
                        data: 'status',
                        className: 'text-left',
                        render: function(data, type, row, meta) {
                            console.log(data);
                            var badgeColor = ``;
                            switch (row.status) {
                                case 'Waiting Approval For Manager':
                                    badgeColor = `danger`;
                                    break;
                                case 'Sent PO':
                                    badgeColor = `primary`;
                                    break;
                                case 'Approved By Manager':
                                    badgeColor = `success`;
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
                                </a> |
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
        </script>
    </x-slot>
</x-app-layout>