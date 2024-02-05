<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <h4><b>{{ $tracking->purchase_order_supplier->transaction_code }}</b></h4>
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
                                                <label class="col-lg-3 col-form-label">SO Number</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->id }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Customer Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->inquiry->visit->customer->name }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Due Date to CS</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ \Carbon\Carbon::parse($tracking->purchase_order_supplier->sales_order->inquiry->due_date)->format('d F Y') }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Subject</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->inquiry->subject }}"
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
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->sourcing->selected_sourcing_suppliers[0]->supplier->company }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Supplier Telephone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->sourcing->selected_sourcing_suppliers[0]->supplier->company_phone }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->sourcing->selected_sourcing_suppliers[0]->supplier->sales_representation }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Email - Phone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->sourcing->selected_sourcing_suppliers[0]->supplier->sales_email }}"
                                                        readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tracking->purchase_order_supplier->sales_order->sourcing->selected_sourcing_suppliers[0]->supplier->sales_number }}"
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
    </div>
    <x-slot name="js">
        <script>
            $(document).ready(function() {
                var productData = {!! json_encode($tracking) !!};
                console.log(productData);
                listItemTable(productData);
            });

            const handleCurrencyFormat = (value) => {
                if (value) {
                    return value.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 2,
                    });
                } else {
                    return "N/A"; // Atau nilai default lainnya
                }
            }

            function listItemTable(data) {
                $("#product-list").html('');
                let datas = data.purchase_order_supplier.sales_order.sourcing.selected_sourcing_suppliers;

                // console.log(datas);
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

                    var formattedShippingValue = handleCurrencyFormat(data.purchase_order_supplier.total_shipping_value);
                    element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td colspan="4">${data.purchase_order_supplier.total_shipping_note}</td>
                                        <th class="text-center">${formattedShippingValue}</th>
                                    </tr>
                                    <tr>
                        <td class="text-center">${number + 1}.</td>    
                        <td colspan="4">Subtotal.</td>    
                        <th class="text-center">${handleCurrencyFormat(subtotal + data.purchase_order_supplier.total_shipping_value)}</th>
                    </tr>
                    <tr>
                        <td class="text-center">${number + 2}.</td>    
                        <td colspan="4">PPN 11%.</td>    
                        <th class="text-center">${handleCurrencyFormat(data.purchase_order_supplier.vat === 'INCLUDE_11' ? (subtotal + data.purchase_order_supplier.total_shipping_value) * 0.11 : 0)}</th>
                    </tr>
                    <tr>
                        <td class="text-center">${number + 3}.</td>    
                        <td colspan="4">Grand Total.</td>    
                        <th class="text-center">${handleCurrencyFormat(data.purchase_order_supplier.vat === 'INCLUDE_11' ? subtotal + (subtotal * 0.11) : subtotal)}</th>
                    </tr>`;

                    $("#product-list").append(element);
                }
            }
        </script>
    </x-slot>
</x-app-layout>
