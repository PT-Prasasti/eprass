<x-app-layout>
    <div class="content">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <h4><b>{{ $query->transaction_code }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-success mr-5 mb-5">
                        <a href="{{ route('approval-po.approve', $query->id) }}" class="text-white">
                        <i class="fa fa-save mr-5"></i>Approve

                        </a>
                    </button>
                    <button type="button" class="btn btn-danger mr-5 mb-5">
                        <i class="fa fa-close mr-5"></i>Rejected
                    </button>
                </div>
            </div>

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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <span class="d-block">
                                    {{ $loop->iteration }}. {{ $error }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#btabs-static-home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#term_con">Term &amp; Condition</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pick-up-information">Pick Up Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#document">Document</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        PO Supplier
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            value="{{ $query->purchase_order_supplier->transaction_code }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Subject</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            value="{{ $query->purchase_order_supplier->sales_order->inquiry->subject }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Supplier Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            value="{{ $query->purchase_order_supplier->supplier->company }}"
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
                                                    <label class="col-lg-3 col-form-label">
                                                        Nominal
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="nominal"
                                                            autocomplete="one-time-code" class="form-control"
                                                            value="{{ number_format($query->value, 0, ',', '.') }}"
                                                            number_format readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Due Date
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="due_date"
                                                            autocomplete="one-time-code" class="form-control"
                                                            value="{{ $query->transaction_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Note
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="note"
                                                            autocomplete="one-time-code" class="form-control"
                                                            value="{{ $query->note }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List</h5>
                                    </div>
                                </div>
                                <table class="table table-bordered table-center" purchase_order_supplier_items>
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Delevery Time</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="p-0" colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-left" colspan="3"
                                                purchase_order_supplier_shipping_fee_note>Shipping Fee</td>
                                            <th class="text-right" purchase_order_supplier_shipping_fee_value></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-left" colspan="3">Subtotal</td>
                                            <th class="text-right" purchase_order_supplier_subtotal></th>
                                            <th></th>
                                        </tr>
                                        <tr purchase_order_supplier_vat>
                                            <th></th>
                                            <td class="text-left" colspan="3">PPN 11%</td>
                                            <th class="text-right" purchase_order_supplier_vat_value></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-left" colspan="3">Grand Total</td>
                                            <th class="text-right" purchase_order_supplier_grand_total></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="tab-pane" id="term_con" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Term
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->term }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Delivery
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->delivery }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Note
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->note }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Payment Term
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->payment_term_to_text }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        PPN
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->vat_to_text }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Attachment
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $query->purchase_order_supplier->attachment }}"
                                                        required="" autocomplete="one-time-code" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="pick-up-information" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="pick_up_information_name">Name</label>
                                                    <input id="pick_up_information_name" type="text"
                                                        class="form-control" name="pick_up_information_name"
                                                        value="{{ $query->pick_up_information_name }}"
                                                        autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pick_up_information_email">Email</label>
                                                    <input id="pick_up_information_email" type="text"
                                                        class="form-control" name="pick_up_information_email"
                                                        value="{{ $query->pick_up_information_email }}"
                                                        autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pick_up_information_phone_number">Phone Number</label>
                                                    <input id="pick_up_information_phone_number" type="text"
                                                        class="form-control" name="pick_up_information_phone_number"
                                                        value="{{ $query->pick_up_information_phone_number }}"
                                                        autocomplete="one-time-code" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pick_up_information_mobile_number">
                                                        Mobile Number
                                                    </label>
                                                    <input id="pick_up_information_mobile_number" type="text"
                                                        class="form-control" name="pick_up_information_mobile_number"
                                                        value="{{ $query->pick_up_information_mobile_number }}"
                                                        autocomplete="one-time-code" readonly>
                                                </div>
                                                <div clasa="form-group">
                                                    <label for="pick_up_information_pick_up_address">
                                                        Pick Up Address
                                                    </label>
                                                    <textarea class="form-control" id="pick_up_information_pick_up_address" name="pick_up_information_pick_up_address"
                                                        rows="4" readonly>{{ $query->pick_up_information_pick_up_address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {{-- <div class="form-group row">
                                                    <label class="col-12">Document Pick Up Information :</label>
                                                    <div class="col-12">
                                                        <p>1.<a href="#"> Packing List.pdf</a></p>
                                                        <p>2.<a href="#"> Packing List Detail.pdf</a></p>
                                                    </div>
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

            const purchaseOrderSupplierItemTable = $('[purchase_order_supplier_items]').DataTable({
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        searchable: false,
                        orderable: false,
                        className: 'align-top text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-top',
                        render: function(data, type, row, meta) {
                            return `
                                ${row.selected_sourcing_supplier.sourcing_supplier.item_name}
                                <br/>${row.selected_sourcing_supplier.sourcing_supplier.description}
                                <br/>${row.selected_sourcing_supplier.sourcing_supplier.inquiry_product.size}
                                <br/>${row.selected_sourcing_supplier.sourcing_supplier.inquiry_product.remark}
                            `;
                        },
                    },
                    {
                        data: 'quantity',
                        className: 'align-top text-right',
                    },
                    {
                        data: 'cost',
                        className: 'align-top text-right',
                        render: function(data, type, row, meta) {
                            return `<span class="text-nowrap">${handleCurrencyFormat(Number(row.cost))}</span>`;
                        },
                    },
                    {
                        data: 'price',
                        searchable: false,
                        orderable: false,
                        className: 'align-top text-right',
                        // render: function(data, type, row, meta) {
                        //     return `<span class="text-nowrap">${handleCurrencyFormat(Number(row.price))}</span>`;
                        // }
                        render: function(data, type, row, meta) {
                            return `<span class="text-nowrap">${handleCurrencyFormat(Number(row.quantity*row.cost))}</span>`;
                        }
                    },
                    {
                        data: 'delivery_time',
                        className: 'align-top',
                    }
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                },
            });

            const handleSetPurchaseOrderSupplier = (data) => {
                purchaseOrderSupplierItemTable.clear().draw();
                purchaseOrderSupplierItemTable.rows.add(data.purchase_order_supplier_items ?? []).draw(true);

                $(`[purchase_order_supplier_subject]`).val(data.supplier.company);
                $(`[purchase_order_supplier_supplier]`).val(data.sales_order.inquiry.subject);
                $(`[purchase_order_supplier_term]`).val(data.term);
                $(`[purchase_order_supplier_delivery]`).val(data.delivery);
                $(`[purchase_order_supplier_note]`).val(data.note);
                $(`[purchase_order_supplier_payment_term]`).val(data.payment_term);
                $(`[purchase_order_supplier_vat]`).val(data.vat);
                $(`[purchase_order_supplier_attachment]`).val(data.attachment);

                var subtotal = totalVat = 0;

                if (data.purchase_order_supplier_items.length > 0) {
                    data.purchase_order_supplier_items.map((data, index) => {
                        subtotal += Number(data.price);
                    });
                }

                $(`[purchase_order_supplier_shipping_fee_note]`).html(data.total_shipping_note);
                $(`[purchase_order_supplier_shipping_fee_value]`).html(
                    handleCurrencyFormat(Number(data.total_shipping_value))
                );
                $(`[purchase_order_supplier_subtotal]`).html(
                    handleCurrencyFormat(Number(subtotal += data.total_shipping_value))
                );

                if (data.vat == `<?= \App\Constants\VatTypeConstant::INCLUDE_11 ?>`) {
                    $(`[ purchase_order_supplier_vat]`).prop('hidden', false);
                    totalVat = (subtotal * 11) / 100;
                } else {
                    $(`[ purchase_order_supplier_vat]`).prop('hidden', true);
                    totalVat = 0;
                }

                $(`[purchase_order_supplier_vat_value]`).html(
                    handleCurrencyFormat(
                        Number(totalVat)
                    )
                );
                $(`[purchase_order_supplier_grand_total]`).html(
                    handleCurrencyFormat(
                        Number(subtotal + totalVat)
                    )
                );
            }

            const handleCalculate = () => {
                const data = $(`[selected_sales_order_items] > tbody`).children()
                if (data.length) {
                    data.map((index, row) => {
                        const dataId = $(row).data('id');
                        const quantity = handleSetNumber($(`[name="item[${dataId}][quantity]"]`).val());
                        const cost = handleSetNumber($(`[name="item[${dataId}][cost]"]`).val());
                        const price = quantity * cost;

                        $(row).find('[price]').html(handleCurrencyFormat(price));
                    });
                }

                const totalShippingValue = $(`[name="total_shipping_value"]`).val();
                $(`[total_shipping_total]`).html(handleCurrencyFormat(handleSetNumber(totalShippingValue)));
            }

            handleSetPurchaseOrderSupplier({!! $query->purchase_order_supplier->toJson() !!});

            $(document).on("input", "[number_format]", function() {
                this.value = handleRupiahFormat(handleSetNumber(this.value));
            });

            // handleCalculate();
        </script>
    </x-slot>
</x-app-layout>
