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
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <input type="text" class="form-control" name="dt_production">
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <input type="text" class="form-control" name="delivery_time">
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <select class="form-control" name="currency">
                                        <option selected disabled>Choose Currency</option>
                                        <option value="USD">USD</option>
                                        <option value="IDR">IDR</option>
                                    </select>
                                `
                            }
                        },
                        {
                            data: 'id',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <select class="form-control" name="shipping_fee">
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
                                    <select class="form-control" name="profit">
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
                    }
                })
                $('#data_table').on('change',
                    'select[name="currency"], input[name="dt_production"], input[name="price"], select[name="shipping_fee"], select[name="profit"]',
                    function() {
                        var row = $(this).closest('tr')
                        var currency = row.find('select[name="currency"]').val()
                        var unitPrice = parseFloat(row.find('td:nth-child(7)').html())
                        var shippingFee = parseFloat(row.find('select[name="shipping_fee"]').val())
                        var profit = parseFloat(row.find('select[name="profit"]').val())
                        var dtProduction = parseFloat(row.find('input[name="dt_production"]').val())
                        var qty = parseFloat(row.find('td:nth-child(3)').html())

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
                            }
                            console.log(total);
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
                        console.log(data)
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
    </x-slot>
</x-app-layout>
