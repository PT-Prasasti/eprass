<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('transaction.sales-order.price.store', $so->uuid) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Price List : {{ $so->id }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Price List
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" id="viewTable">
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
                                                <th class="text-center">Unit Selling Price</th>
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
        </form>
    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                dataTable()
            })

            function dataTable() {
                $('#viewTable').html('')
                $('#viewTable').html(`
                    <table class="table table-bordered table-vcenter js-dataTable-simple"
                        style="font-size:10px" id="data_table">
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
                                <th class="text-center">Unit Selling Price</th>
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
                            "so": "{{ $so->uuid }}"
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: '8%',
                            className: 'text-center'
                        },
                        {
                            data: 'item_desc',
                            className: 'text-center'
                        },
                        {
                            data: 'qty',
                            className: 'text-center'
                        },
                        {
                            data: 'supplier',
                            className: 'text-center'
                        },
                        {
                            data: 'description',
                            className: 'text-center'
                        },
                        {
                            data: 'qty_sourcing',
                            className: 'text-center'
                        },
                        {
                            data: 'price',
                            className: 'text-center unit-price'
                        },
                        {
                            data: 'dt',
                            className: 'text-center',
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <input type="text" class="simple-form-control" name="price_list[${row.uuid}][delivery_time]" value="` +
                                    row
                                    .dt + `">
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                CUR = row.curency.toUpperCase();
                                return `
                                    <select class="simple-form-control" name="price_list[${row.uuid}][currency]" calculate>
                                        <option selected disabled>Choose Currency</option>
                                        <option value="USD" ` + (CUR == "USD" ? "selected" : "") + `>USD</option>
                                        <option value="IDR" ` + (CUR == "IDR" ? "selected" : "") + `>IDR</option>
                                    </select>
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <select class="simple-form-control" name="price_list[${row.uuid}][shipping_fee]" calculate>
                                        <option selected disabled>Choose Shipping Fee</option>
                                        <option value="2.0">2,0</option>
                                        <option value="1.9">1,9</option>
                                        <option value="1.8">1,8</option>
                                        <option value="1.7">1,7</option>
                                        <option value="1.6">1,6</option>
                                        <option value="1.5">1,5</option>
                                        <option value="1.4">1,4</option>
                                        <option value="1.3">1,3</option>
                                        <option value="1.2">1,2</option>
                                        <option value="1.1">1,1</option>
                                    </select>
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            width: '8%',
                            render: function(data, type, row) {
                                return `
                                    <select class="simple-form-control" name="price_list[${row.uuid}][profit]" calculate>
                                        <option selected disabled>Choose Profit</option>
                                        <option value="0.9">0,9</option>
                                        <option value="0.8">0,8</option>
                                        <option value="0.7">0,7</option>
                                        <option value="0.6">0,6</option>
                                        <option value="0.5">0,5</option>
                                        <option value="0.4">0,4</option>
                                        <option value="0.3">0,3</option>
                                        <option value="0.2">0,2</option>
                                        <option value="0.1">0,1</option>
                                    </select>

                                    <input type="hidden" name="price_list[${row.uuid}][cost]" value="0">
                                    <input type="hidden" name="price_list[${row.uuid}][total_cost]" value="0">
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <span class="unit-selling-price p-0"></span>
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <span class="total-cell p-0"></span>
                                `
                            }
                        },

                    ],
                    "language ": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    },
                    "fnRowCallback": function(nRow, aData) {
                        var $nRow = $(nRow);
                        $nRow.attr("data-uuid", aData['uuid']);

                        return nRow;
                    },
                });

                $('#data_table').on('change',
                    '[calculate]',
                    function() {
                        var row = $(this).closest('tr')
                        var dataId = row.data('uuid')
                        var currency = row.find(`select[name="price_list[${dataId}][currency]`).val()
                        var unitPrice = parseFloat(row.find('td:nth-child(7)').html())
                        var shippingFee = parseFloat(row.find(`select[name="price_list[${dataId}][shipping_fee]`).val())
                        var profit = parseFloat(row.find(`select[name="price_list[${dataId}][profit]`).val())
                        var qty = parseFloat(row.find('td:nth-child(3)').html())

                        row.find(`input[name="price_list[${dataId}][cost]`).val(0)
                        row.find(`input[name="price_list[${dataId}][total_cost]`).val(0)

                        if (currency != null && !isNaN(shippingFee) && !isNaN(profit) && !isNaN(qty)) {
                            if (currency == 'USD') {
                                currencyConverter(unitPrice, function(currencyData) {
                                    if (currencyData) {
                                        var total = (currencyData.amount * shippingFee / profit) *
                                            qty;
                                        var unitSellingPrice = currencyData.amount * shippingFee /
                                            profit;
                                        row.find('td:nth-child(14)').html(formatCurrency(total))
                                        row.find('td:nth-child(13)').html(formatCurrency(
                                            unitSellingPrice))

                                        row.find(`input[name="price_list[${dataId}][total_cost]`).val(
                                            unitSellingPrice
                                        )
                                        row.find(`input[name="price_list[${dataId}][cost]`).val(total)
                                    } else {
                                        row.find('td:nth-child(14)').html('')
                                        row.find('td:nth-child(13)').html('')
                                    }
                                })
                            } else {
                                var total = (unitPrice * shippingFee / profit) * qty;
                                var unitSellingPrice = unitPrice * shippingFee / profit;
                                row.find('td:nth-child(14)').html(formatCurrency(total))
                                row.find('td:nth-child(13)').html(formatCurrency(unitSellingPrice))

                                row.find(`input[name="price_list[${dataId}][total_cost]`).val(
                                    unitSellingPrice
                                )
                                row.find(`input[name="price_list[${dataId}][cost]`).val(total)
                            }
                        } else {
                            row.find('td:nth-child(14)').html('')
                            row.find('td:nth-child(13)').html('')
                        }
                    })
            }

            function currencyConverter(usd, callback) {
                $.ajax({
                    url: "{{ route('transaction.sales-order.currency_converter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "usd": usd
                    },
                    success: function(data) {
                        callback(data)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.responseText);
                        callback(null)
                    }
                })
            }

            function formatCurrency(amount) {
                return amount.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }
        </script>
        <style>
            .simple-form-control {
                height: 25px;
                border-radius: 6px;
                border: solid 1px #ccc;
                padding: 5px 6px;
                background-color: #fff;
            }
        </style>
    </x-slot>
</x-app-layout>
