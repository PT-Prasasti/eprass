<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('transaction.quotation.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Add Quotation</b></h4>
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
                                <a class="nav-link" href="#btabs-static-review">Detail Price</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-static-review2">Term &amp; Condition</a>
                            </li>
                        </ul>

                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="block block-rounded">
                                            <div class="block-content block-content-full bg-pattern">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">SO Number</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control" name="sales_order"
                                                                    required="">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">ID Inquiry</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly inquiry_code>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Sales Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly sales_name>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Customer & Company
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly customer_name>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly company_name>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Phone & Email</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly phone_number>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly email>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Telp</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly phone>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Subject</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly subject>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Due Date</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly due_date>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Grade</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    value="" readonly grade>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="block block-rounded">
                                            <div class="block-content block-content-full bg-pattern">
                                                <h5 name="document">Document List</h5>
                                                <a href="" target="_blank" hidden file>
                                                    <i class="fa fa-eye"></i>
                                                    Show File
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-pattern">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Product List</h5>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-center" style="font-size:13px"
                                            sales_order_products>
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">Material Description</th>
                                                    <th class="text-center">Size</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-pattern">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Note</h5>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <div note></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-pattern">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped table-vcenter table-bordered w-100"
                                                        style="font-size:14px" list_price_items>
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Item Name</th>
                                                                <th class="text-center">Material Desc</th>
                                                                <th class="text-center">Size</th>
                                                                <th class="text-center" style="width: 2%;">QTY</th>
                                                                <th class="text-center" style="width: 2%;">Remark</th>
                                                                <th class="text-center" style="width: 12%;">
                                                                    Delivery Time
                                                                </th>
                                                                <th class="text-center" style="width: 8%;">Unit Price
                                                                </th>
                                                                <th class="text-center" style="width: 20%;">UP Price
                                                                </th>
                                                                <th class="text-center" style="width: 10%;">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="btabs-static-review2" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Quotation Valid Until
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" class="form-control" name="due_date"
                                                        value="{{ old('due_date', date('Y-m-d')) }}" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Delivery Term
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="delivery_term"
                                                        value="{{ old('delivery_term') }}" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Validity
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="validity"
                                                        value="{{ old('validity') }}" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Payment Term
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control" name="payment_term" required="">
                                                        <option value="">Select one</option>
                                                        @foreach ($paymentTerms as $itemKey => $itemValue)
                                                            <option value="{{ $itemKey }}"
                                                                {{ $itemKey === old('payment_term') ? 'selected' : '' }}>
                                                                {{ $itemValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        PPN
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control" name="vat" required="">
                                                        <option value="">Select one</option>
                                                        @foreach ($vatTypes as $itemKey => $itemValue)
                                                            <option value="{{ $itemKey }}"
                                                                {{ $itemKey === old('vat') ? 'selected' : '' }}>
                                                                {{ $itemValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Attachment
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="attachment"
                                                        value="{{ old('attachment') }}" required="">
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
        </form>
    </div>

    <x-slot name="js">
        <script>
            const handleCurrencyFormat = (value) => {
                return value.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            const salesOrderProductTable = $('[sales_order_products]').DataTable({
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'item_name',
                    },
                    {
                        data: 'description',
                    },
                    {
                        data: 'size',
                        className: 'text-right',
                    },
                    {
                        data: 'qty',
                        className: 'text-right',
                    },
                    {
                        data: 'remark',
                    }
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
            });

            const listPriceItemTable = $('[list_price_items]').DataTable({
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
                    },
                    {
                        data: 'description',
                        className: 'align-top',
                    },
                    {
                        data: 'size',
                        className: 'text-right align-top',
                    },
                    {
                        data: 'sourcing_qty',
                        className: 'text-right align-top',
                    },
                    {
                        data: 'remark',
                        className: 'align-top',
                    },
                    {
                        data: 'delivery_time',
                        className: 'align-top',
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
                            return `
                                <input type="hidden" name="item[${row.uuid}][original_cost]" placeholder="" value="${Number(row.cost).toFixed(2)}">
                                <input type="text" class="form-control form-control-sm w-100" name="item[${row.uuid}][cost]" placeholder="" value="${Number(row.cost).toFixed(2)}" autocomplete="one-time-code" style="min-width: 125px;" number_format>
                                <span class="d-block small text-left text-danger mt-1" style="line-height: 1.25em;" number_format_validation></span>
                            `;
                        }
                    },
                    {
                        className: 'text-right align-top',
                        render: function(data, type, row, meta) {
                            return `<span total_cost>${handleCurrencyFormat(row.qty*row.cost)}</span>`;
                        }
                    },
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-uuid', aData.uuid);
                    $(nRow).attr('data-quantity', aData.qty);
                    $(nRow).attr('data-cost', aData.cost);
                },
            });

            const handleSetSalesOrder = (data) => {
                const inquiryCodeElement = $(`[inquiry_code]`);
                const salesNameElement = $(`[sales_name]`);
                const customerNameElement = $(`[customer_name]`);
                const companyNameElement = $(`[company_name]`);
                const phoneNumberElement = $(`[phone_number]`);
                const emailElement = $(`[email]`);
                const phoneElement = $(`[phone]`);
                const subjectElement = $(`[subject]`);
                const dueDateElement = $(`[due_date]`);
                const gradeElement = $(`[grade]`);
                const noteElement = $(`[note]`);
                const fileElement = $(`[file]`);

                inquiryCodeElement.val(data.inquiry?.id ?? '');
                salesNameElement.val(data.inquiry?.sales?.name ?? '');
                customerNameElement.val(data.inquiry?.visit.customer?.name ?? '');
                companyNameElement.val(data.inquiry?.visit.customer?.company ?? '');
                phoneNumberElement.val(data.inquiry?.visit.customer?.phone ?? '');
                emailElement.val(data.inquiry?.visit.customer?.email ?? '');
                phoneElement.val(data.inquiry?.visit.customer?.company_phone ?? '');
                subjectElement.val(data.inquiry?.subject ?? '');
                dueDateElement.val(data.due_date ?? '');
                gradeElement.val(data.inquiry?.grade ? `${data.inquiry?.grade} %` : '');
                noteElement.html(data.inquiry?.description ?? '');

                if (data.inquiry?.files) {
                    files = JSON.parse(data.inquiry?.files);

                    fileElement.attr('href',
                        `{{ url('') }}/file/show/inquiry/${data.inquiry.visit.uuid}/${files[0].filename}`);

                    fileElement.prop('hidden', false);
                } else {
                    fileElement.attr('href', '#');
                    fileElement.prop('hidden', true);
                }

                salesOrderProductTable.clear().draw();
                salesOrderProductTable.rows.add(data.inquiry?.products ?? []).draw(true);

                listPriceItemTable.clear().draw();
                listPriceItemTable.rows.add(data.inquiry?.products ?? []).draw(true);

                @if (session('salesOrder') && is_array(old('item')))
                    @foreach (old('item') as $itemId => $itemValue)
                        $(`[name="item[{{ $itemId }}][cost]"]`).val(`{{ $itemValue['cost'] }}`);
                        $(`[name="item[{{ $itemId }}][cost]"]`).trigger("input");
                    @endforeach
                @endif
            }

            $(`[name="sales_order"]`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('transaction.quotation.search.sales-orders') }}`,
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
                                    id: object.uuid,
                                    text: object.id,
                                    data: object,
                                    disabled: !object.can_be_added_quotation,
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

            $(document).on('select2:selecting', `[name="sales_order"]`, function(e) {
                const data = e.params.args.data.data;
                handleSetSalesOrder(data);
            });

            $(document).on("input", "[number_format]", function() {
                const row = $(this).closest('tr');

                this.value = Number(this.value.replace(/[^0-9.]/g, '')).toFixed(2);
                if (this.value < row.data('cost')) {
                    row.find(`[number_format_validation]`).html(
                        `Nilai tidak boleh lebih kurang dari ${handleCurrencyFormat(row.data('cost'))}`);
                } else {
                    row.find(`[number_format_validation]`).html('');
                }

                row.find(`[total_cost]`).html(
                    handleCurrencyFormat(
                        row.data('quantity') *
                        this.value
                    )
                );
            });

            @if (session('salesOrder'))
                $(`[name="sales_order"]`).select2("trigger", "select", {
                    data: {
                        id: `{{ session('salesOrder')->uuid }}`,
                        text: `{{ session('salesOrder')->id }}`,
                        data: {!! session('salesOrder')->toJson() !!}
                    }
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>
