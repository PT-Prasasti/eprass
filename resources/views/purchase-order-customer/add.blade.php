<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('purchase-order-customer.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Add PO Customer</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Quotation
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
                                <a class="nav-link" href="#detail_quotation">Detail Quotation</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Quotation Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="quotation" required="">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Sales Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly sales_name>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Customer & Company Name
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly customer_name>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly company_name>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Phonne & Email</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly phone_number>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly email>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Telp</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly phone>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Subject</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="" readonly subject>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="purchase_order_number" autocomplete="one-time-code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input js-custom-file-input-enabled"
                                                id="example-file-input-custom" name="example-file-input-custom"
                                                data-toggle="custom-file-input">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose
                                                file</label>
                                        </div>
                                        <div class="block block-rounded">
                                            <div class="block-content block-content-full bg-pattern">
                                                <h5>Document List</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List</h5>
                                    </div>
                                </div>
                                <table class="table table-bordered table-center" style="font-size:13px"
                                    quotation_items>
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
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="detail_quotation" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="text-center" style="margin-top:-8px">
                                            <h5>QUOTATION</h5>
                                        </div>

                                        <hr style="border-top: 4px solid #000; margin-top:-5px;">

                                        <div class="row">
                                            <div class="col-md-6 row">
                                                <div class="col-md-2">
                                                    <label> To
                                                        <br>
                                                        <br>
                                                        <br>
                                                        Attn<br>
                                                        Reff<br>
                                                        Subject<br>
                                                        Phone<br>
                                                        Fax<br>
                                                        E-mail
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label>:
                                                        <span span-quotation-customer-company></span>
                                                        <br>
                                                        &nbsp;
                                                        <span span-quotation-customer-address></span>
                                                        <br><br>
                                                        : <span span-quotation-customer-name></span>
                                                        <br>
                                                        : -<br>
                                                        : <span span-quotation-inquiry-subject></span>
                                                        <br>
                                                        : <span span-quotation-customer-phone></span><br>
                                                        : <span span-quotation-customer-company-fax></span><br>
                                                        : <span span-quotation-customer-email></span><br>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 row">
                                                <div class="col-md-6">
                                                    <label> No<br>
                                                        Date<br>
                                                        Qutation Valid Until<br>
                                                        Prepared by<br>
                                                        Sales Rep<br>
                                                        Phone
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label> : <span span-quotation-code></span><br>
                                                        : <span span-quotation-date></span><br>
                                                        : <span span-quotation-due-date></span><br>
                                                        : <span span-quotation-sales-name></span><br>
                                                        : <span span-quotation-sales-name></span><br>
                                                        : <span span-quotation-sales-phone></span><br>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <p>We thank you for your inquiry and we are pleased to submit our best offer
                                                for your kind consideration :</p>
                                        </div>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        <p>No</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Item Name</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Qty</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Unit Price</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Total Price</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Delivery Time</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody tbody-quotation-items></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3">
                                                        Document: <span span-quotation-document></span>
                                                    </td>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <tr tr-is-visible-subtotal hidden>
                                                    <td colspan="3"></td>
                                                    <td class="text-right">
                                                        <p><b>Subtotal</b></p>
                                                    </td>
                                                    <td class="text-right text-nowrap">
                                                        <p>
                                                            <b span-quotation-subtotal></b>
                                                        </p>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr tr-is-visible-vat hidden>
                                                    <td colspan="3"></td>
                                                    <td class="text-right">
                                                        <p><b>PPN 11%</b>
                                                        </p>
                                                    </td>
                                                    <td class="text-right text-nowrap">
                                                        <p>
                                                            <b span-quotation-vat-total></b>
                                                        </p>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td class="text-right">
                                                        <p><b>Total</b></p>
                                                    </td>
                                                    <td class="text-right text-nowrap">
                                                        <p>
                                                            <b span-quotation-total></b>
                                                        </p>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="mt-2">
                                            <label>
                                                Remarks :<br>
                                                Equipment qouted is based on the information provided by your
                                                goodselves. We reserve the right<br>
                                                to re-qouted should there be any deviations/clarifications or upon
                                                receipt of detail specifications.<br>
                                            </label>
                                        </div>

                                        <div class="mt-2">
                                            <p><b>Terms &amp; Conditions</b></p>
                                            <hr style="border-top: 1px solid #000; margin-top: -10px">
                                            <hr style="border-top: 1px solid #000; margin-top: -12px">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>
                                                        1. Price<br>
                                                        2. Delivery Term<br>
                                                        3. Term of Payment<br>
                                                        4. Validity<br>
                                                        5. VAT
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label>
                                                        : IDR Basis <br>
                                                        : <span span-quotation-delivery-term></span><br>
                                                        : <span span-quotation-payment-term></span><br>
                                                        : <span span-quotation-validity></span><br>
                                                        : <span span-quotation-vat></span><br>
                                                    </label>
                                                </div>
                                            </div>
                                            <hr style="border-top: 1px solid #000; margin-top: -3px">
                                            <hr style="border-top: 1px solid #000; margin-top: -12px">
                                        </div>

                                        <div class="mt-2">
                                            <label>
                                                Price subject to change if quantity is changed.<br>
                                                Please confirm our selection. If you require information, please do not
                                                hesitate to contact us.<br>
                                            </label>
                                        </div>

                                        <div class="mt-4">
                                            <p class="mb-0">Best Regards</p>
                                            <img src="" alt="tanda-tangan" class="mt-2 mb-2"
                                                style="width: 200px; height: 80px;" hidden
                                                span-quotation-sales-signature>
                                            <p span-quotation-sales-name></p>
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

            const quotationItemTable = $('[quotation_items]').DataTable({
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        searchable: false,
                        orderable: false,
                        className: 'text-center align-top',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'item_name',
                        className: 'align-top',
                        render: function(data, type, row, meta) {
                            return `
                                ${row.inquiry_product.item_name}
                                </br>${row.inquiry_product.description}
                                </br>${row.inquiry_product.size}
                                </br>${row.inquiry_product.remark}
                            `;
                        },
                    },
                    {
                        data: 'inquiry_product.sourcing_qty',
                        className: 'align-top text-right',
                    },
                    {
                        data: 'cost',
                        className: 'text-right align-top',
                        render: function(data, type, row, meta) {
                            return handleCurrencyFormat(Number(row.cost));
                        },
                    },
                    {
                        className: 'align-top p-2',
                        render: function(data, type, row, meta) {
                            return `<span total_cost>${handleCurrencyFormat(Number(row.total_cost))}</span>`;
                        }
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-top',
                        render: function(data, type, row, meta) {
                            return `
                                <input type="text" class="form-control form-control-sm w-100" name="item[${row.id}][delivery_time]" placeholder="" value="${row.inquiry_product.delivery_time}" autocomplete="one-time-code" style="min-width: 100px;">
                            `;
                        }
                    },
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                },
            });

            const handleSetQuotation = (data) => {
                const salesNameElement = $(`[sales_name]`);
                const customerNameElement = $(`[customer_name]`);
                const companyNameElement = $(`[company_name]`);
                const phoneNumberElement = $(`[phone_number]`);
                const emailElement = $(`[email]`);
                const phoneElement = $(`[phone]`);
                const subjectElement = $(`[subject]`);

                salesNameElement.val(data.sales_order?.inquiry?.sales?.name ?? '');
                customerNameElement.val(data.sales_order?.inquiry?.visit.customer?.name ?? '');
                companyNameElement.val(data.sales_order?.inquiry?.visit.customer?.company ?? '');
                phoneNumberElement.val(data.sales_order?.inquiry?.visit.customer?.phone ?? '');
                emailElement.val(data.sales_order?.inquiry?.visit.customer?.email ?? '');
                phoneElement.val(data.sales_order?.inquiry?.visit.customer?.company_phone ?? '');
                subjectElement.val(data.sales_order?.inquiry?.subject ?? '');

                quotationItemTable.clear().draw();
                quotationItemTable.rows.add(data.quotation_items ?? []).draw(true);

                @if (session('quotation') && is_array(old('item')))
                    @foreach (old('item') as $itemId => $itemValue)
                        $(`[name="item[{{ $itemId }}][delivery_time]"]`).val(`{{ $itemValue['delivery_time'] }}`);
                    @endforeach
                @endif

                // quotation print
                $(`[span-quotation-customer-company]`).html(data.sales_order?.inquiry?.visit.customer?.company ?? '-');
                $(`[span-quotation-customer-address]`).html(data.sales_order?.inquiry?.visit.customer?.address ?? '-');
                $(`[span-quotation-customer-name]`).html(data.sales_order?.inquiry?.visit.customer?.name ?? '-');
                $(`[span-quotation-inquiry-subject]`).html(data.sales_order?.inquiry?.subject ?? '-');
                $(`[span-quotation-customer-phone]`).html(data.sales_order?.inquiry?.visit.customer?.phone ?? '-');
                $(`[span-quotation-customer-company-fax]`).html(data.sales_order?.inquiry?.visit.customer?.company_fax ??
                    '-');
                $(`[span-quotation-customer-email]`).html(data.sales_order?.inquiry?.visit.customer?.email ?? '-');
                $(`[span-quotation-code]`).html(data.quotation_code ?? '-');
                $(`[span-quotation-date]`).html(data.created_at ? data.created_at.slice(0, 10) : '-');
                $(`[span-quotation-due-date]`).html(data.due_date ?? '-');
                $(`[span-quotation-sales-name]`).html(data.sales_order?.inquiry?.sales?.name ?? '-');
                $(`[span-quotation-sales-phone]`).html(data.sales_order?.inquiry?.sales?.phone ?? '-');
                $(`[span-quotation-document]`).html(data.attachment ?? '-');

                if (data.sales_order?.inquiry?.sales?.sign) {
                    $(`[span-quotation-sales-signature]`).prop('hidden', false);
                    $(`[span-quotation-sales-signature]`).attr(
                        'src',
                        (
                            data.sales_order?.inquiry?.sales?.sign ?
                            `{{ asset('storage') }}/${data.sales_order.inquiry.sales.sign}` :
                            ''
                        )
                    );
                } else {
                    $(`[span-quotation-sales-signature]`).prop('hidden', true);
                }

                var subtotal = 0;
                if (data.quotation_items.length > 0) {
                    data.quotation_items.map((data, index) => {
                        $(`[tbody-quotation-items]`).append(`
                            <tr>
                                <td class="text-center">
                                    <p>${index+1}</p>
                                </td>
                                <td>
                                    <p class="m-0">
                                        ${data.inquiry_product.item_name}
                                    </p>
                                    <p class="m-0">
                                        ${data.inquiry_product.description}
                                    </p>
                                    <p class="m-0">
                                        ${data.inquiry_product.item_name}
                                    </p>
                                    <p class="m-0">
                                        ${data.inquiry_product.remark}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p>
                                        ${data.inquiry_product.qty}
                                    </p>
                                </td>
                                <td class="text-right text-nowrap">
                                    <p>
                                        ${handleCurrencyFormat(Number(data.cost))}
                                    </p>
                                </td>
                                <td class="text-right text-nowrap">
                                    <p>
                                        ${handleCurrencyFormat(Number(data.total_cost))}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        ${data.inquiry_product.delivery_time}
                                    </p>
                                </td>
                            </tr>
                        `);

                        subtotal += data.total_cost;
                    });
                } else {
                    $(`[tbody-quotation-items]`).html('');
                }

                totalVat = 0;
                if (data.vat == `<?= \App\Constants\VatTypeConstant::INCLUDE_11 ?>`) {
                    $(`[tr-is-visible-subtotal]`).prop('hidden', false);
                    $(`[tr-is-visible-vat]`).prop('hidden', false);
                    $(`[span-quotation-subtotal]`).html(handleCurrencyFormat(Number(subtotal)));
                    $(`[span-quotation-vat-total]`).html(handleCurrencyFormat(Number(totalVat = (subtotal * 11) / 100)));
                } else {
                    $(`[tr-is-visible-subtotal]`).prop('hidden', true);
                    $(`[tr-is-visible-vat]`).html('hidden', true);
                }

                $(`[span-quotation-total]`).html(handleCurrencyFormat(Number(subtotal += totalVat)));
                $(`[span-quotation-delivery-term]`).html(data.delivery_term ?? '-');
                $(`[span-quotation-payment-term]`).html(data.payment_term_string ?? '-');
                $(`[span-quotation-validity]`).html(data.validity ?? '-');
                $(`[span-quotation-vat]`).html(data.vat_string ?? '-');

            }

            $(`[name="quotation"]`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('purchase-order-customer.search.quotation') }}`,
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
                                    text: object.quotation_code,
                                    data: object,
                                    disabled: object.status != 'Done',
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

            $(document).on('select2:selecting', `[name="quotation"]`, function(e) {
                const data = e.params.args.data.data;
                handleSetQuotation(data);
            });

            @if (session('quotation'))
                $(`[name="quotation"]`).select2("trigger", "select", {
                    data: {
                        id: `{{ session('quotation')->id }}`,
                        text: `{{ session('quotation')->quotation_code }}`,
                        data: {!! session('quotation')->toJson() !!}
                    }
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>
