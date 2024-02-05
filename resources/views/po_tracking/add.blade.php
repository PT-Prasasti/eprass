<x-app-layout>
    <div class="content">
        <form action="{{ route('po-tracking.store') }}" method="POST">
            @csrf
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
                </div>

                <div class="col-lg-6">
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-primary text-white" id="save-tracking">
                        <i class="fa fa-save"></i> Save Data
                    </button>
                </div>

                <div class="col-lg-12">
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#btabs-static-home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pickup">Pick Up Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#document">Document</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#forwarder">Selected Forwarder</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row">
                                    <input type="hidden" id="idPoSuplier" readonly>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" id="selected_po_supplier"
                                                            name="selected_po_supplier">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">SO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="so_number" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Customer Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="customer_name"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Due Date to CS</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="due_date"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Subject</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="subject"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Supplier Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="supplier_name"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Supplier Telephone</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            id="supplier_telephone" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PIC Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="pic_name"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PIC Email - Phone</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="pic_email"
                                                            readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="pic_phone"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List :</h5>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-vcenter" style="font-size:13px"
                                        sales_order_selected_items>
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Supplier Name</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Total Price</th>
                                                <th class="text-center">Delivery Time</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product-list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="pickup" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="last-name-column">Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Email</label>
                                                    <input type="text" class="form-control" id="email"
                                                        required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number"
                                                        required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Mobile Number</label>
                                                    <input type="text" class="form-control" id="mobile_number"
                                                        required="">
                                                </div>
                                                <div clasa="form-group">
                                                    <label for="last-name-column">Pick Up Address</label>
                                                    <textarea class="form-control" id="pickup_adress" rows="4"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {{-- <div class="form-group row">
                                                    <label class="col-12">Document Pick Up Information :</label>
                                                    <!-- <div class="col-12">
                                                        <p>1.<a href="#"> Packing List.pdf</a></p>
                                                        <p>2.<a href="#"> Packing List Detail.pdf</a></p>
                                                    </div> -->
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="document" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f1">INQUIRY</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f2">SALES ORDER</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f3">SOURCING ITEM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f4">PO CUSTOMER</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f4">PO SUPPLIER</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f4">PURCHASING
                                                DOCUMENT</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="forwarder" role="tabpanel">
                                <div class="table-responsive pb-4" id="forwarder-list">

                                </div>
                            </div>

                            <div class="tab-pane" id="forwarder" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-12 mb-2" style="margin-left: -15px">
                                                <button class="btn btn-info text-white" id="btn-add-row-mg">
                                                    <i class="fa fa-plus"></i> Add Forwarder
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const handleCurrencyFormat = (value) => {
                return value.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 2,
                });
            }

            function handleRupiahFormat(number, prefix) {
                let numberToString = number.toString().replace(/[^,\d]/g, ''),
                    split = numberToString.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1].slice(0, 2) : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }

            const handleSetNumber = (number) => {
                let numberToString = number.toString().replace(/[^,\d]/g, '').replace(/,/g, '.');

                return Number(numberToString) ? Number(numberToString) : 0;
            }

            $(`.forwarder_name`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('po-tracking.search.forwarder') }}`,
                    dataType: 'json',
                    language: "id",
                    type: 'GET',
                    delay: 450,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(res) {
                        console.log(res);
                        return {
                            results: $.map(res, function(object) {
                                return {
                                    id: object.id,
                                    text: object.forwarder_name,
                                    data: object,
                                }
                            })
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });

            $(`[name="selected_po_supplier"]`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('po-tracking.search.po_supplier') }}`,
                    dataType: 'json',
                    language: "id",
                    type: 'GET',
                    delay: 450,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(res) {
                        return {
                            results: $.map(res, function(object) {
                                return {
                                    id: object.id,
                                    text: object.transaction_code,
                                    data: object,
                                }
                            })
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });

            $(document).on('select2:selecting', `[name="selected_po_supplier"]`, function(e) {
                const data = e.params.args.data.data;
                console.log(data);
                handleSetSalesOrder(data);
            });

            function forwarder(datas) {
                let item = datas.sales_order.sourcing.selected_sourcing_suppliers;
                $(item).each(function(index, value) {
                    no = index + 1;
                    html = `
                        <div class="carl-long-row carl-long-row-` + index + `" data-rowid="` + index +
                        `" data-prodinq="` + value.sourcing_supplier.inquiry_product.id + `">
                            <div class="item-information">
                                <div class="row m-0">
                                    <div class="col-2">
                                        <small>No.</small>
                                        <p>` + no +
                        `</p>
                                        <input type="hidden" class="product_inquery_id" name="product_inquery_id[]" value="` +
                        value
                        .sourcing_supplier.inquiry_product.id + `">
                                        <input type="hidden" class="so_id" name="so_id[]" value="` + value
                        .sourcing_supplier.id + `">
                                    </div>
                                    <div class="col-8">
                                        <small>Item Description</small>
                                        <p class="m-0">Item Name : ` + value.sourcing_supplier.item_name + `</p>
                                        <p class="m-0">Unit Price : ` + value.sourcing_supplier.unitprice + `</p>
                                        <p class="m-0">Total Price : ` + value.sourcing_supplier.qty * item[index]
                        .sourcing_supplier.unitprice + `</p>
                                        <p class="m-0">Delivery Time : ` + value.sourcing_supplier.dt + `</p>
                                    </div>
                                    <div class="col-2">
                                        <small>Qty</small>
                                        <p>` + value.sourcing_supplier.qty + `</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="forwarder-information-action forwarder-information-action-` + index + `">
                                <a class="btn btn-primary btn-sm text-white" onclick="newform(` + index + `, ` + value
                        .sourcing_supplier.inquiry_product.id + `)">
                                    <i class="fa fa-plus"></i> Add More
                                </a>
                            </div>
                        </div>
                    `;

                    $("#forwarder-list").append(html);

                })

                setTimeout(() => {
                    init()
                }, 300);
            }


            const handleSetSalesOrder = (data) => {
                listItemTable(data);
                forwarder(data);
                $('#customer_name').val(data.sales_order.inquiry.visit.customer.name);
                $('#so_number').val(data.sales_order.id);
                $('#due_date').val(moment(data.sales_order.inquiry.due_date).format('DD MMMM YYYY'));
                $('#subject').val(data.sales_order.inquiry.subject);
                $('#supplier_name').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.company);
                $('#supplier_telephone').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier
                    .company_phone);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone_number').val(data.phone_number);
                $('#mobile_number').val(data.mobile_number);
                $('#pickup_adress').val(data.pickup_adress);
                $('#idPoSuplier').val(data.id);
                $('#pic_name').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_representation);
                $('#pic_email').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_email);
                $('#pic_phone').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_number);
            }


            function listItemTable(data) {
                $("#product-list").html('');
                let datas = data.sales_order.sourcing.selected_sourcing_suppliers;

                if (datas) {
                    var element = ``;
                    var number = 1;
                    var subtotal = totalVat = 0;

                    $.each(datas, function(index, value) {
                        element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td>${datas[index].sourcing_supplier.company}<br>
                                        <td>${datas[index].sourcing_supplier.item_name}<br>
                                        ${datas[index].sourcing_supplier.description}<br>
                                        ${datas[index].sourcing_supplier.inquiry_product.size}<br>
                                        ${datas[index].sourcing_supplier.inquiry_product.remark}<br>
                                        </td>
                                        <td class="text-center">${datas[index].sourcing_supplier.qty}</td>
                                        <td class="text-center">${handleCurrencyFormat(datas[index].sourcing_supplier.price)}</td>
                                        <td class="text-center">${handleCurrencyFormat(datas[index].sourcing_supplier.qty*datas[index].sourcing_supplier.price)}</td>
                                        <td class="text-center">${datas[index].sourcing_supplier.dt}</td>
                                    </tr>`;

                        subtotal += datas[index].sourcing_supplier.qty * datas[index].sourcing_supplier.price;
                        number += 1;
                    });

                    var formattedShippingValue = handleCurrencyFormat(data.total_shipping_value);
                    element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td colspan="4">${data.total_shipping_note}</td>
                                        <th class="text-center">${formattedShippingValue}</th>
                                    </tr>
                                    <tr>
                        <td class="text-center">${number + 1}.</td>    
                        <td colspan="4">Subtotal.</td>    
                        <th class="text-center">${handleCurrencyFormat(subtotal + data.total_shipping_value)}</th>
                    </tr>
                    <tr>
                        <td class="text-center">${number + 2}.</td>    
                        <td colspan="4">PPN 11%.</td>    
                        <th class="text-center">${handleCurrencyFormat(data.vat === 'INCLUDE_11' ? (subtotal + data.total_shipping_value) * 0.11 : 0)}</th>
                    </tr>
                    <tr>
                        <td class="text-center">${number + 3}.</td>    
                        <td colspan="4">Grand Total.</td>    
                        <th class="text-center">${handleCurrencyFormat(data.vat === 'INCLUDE_11' ? subtotal + (subtotal * 0.11) : subtotal)}</th>
                    </tr>`;

                    $("#product-list").append(element);
                }
            }
        </script>
        <script>
            var FORWARDER_OPT = {!! json_encode($forwarders) !!};
            var IS_READONLY = false;
        </script>
        <script src="{{ asset('assets/js/forwarder/form.js') }}"></script>
        <script src="{{ asset('assets/js/suppliyer/function.js') }}"></script>
        <style>
            .item-information {
                width: 400px;
                min-height: 250px;
                display: inline-block;
            }

            .forwarder-information {
                width: 400px;
                min-height: 250px;
                display: inline-block;
                background-color: #efefef;
                padding: 10px 5px;
                border-radius: 7px;
                margin-bottom: 5px;
                margin-right: 5px;
            }

            .forwarder-information-action {
                width: 100px;
                min-height: 250px;
                display: inline-block;
            }

            .carl-long-row {
                min-width: 100%;
            }

            small {
                font-weight: bold;
            }
        </style>
    </x-slot>
</x-app-layout>
