<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('transaction.quotation.revision-store', $query->id) }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="sales_order" value="{{ $query->sales_order->uuid }}">
            <input type="hidden" class="form-control" name="quotation_code" value="{{ $revCode }}">

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Revision Quotation: {{ $revCode }}</b></h4>
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
                                                                <input type="text" class="form-control"
                                                                    name="" value="{{ $query->sales_order->id }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Sales
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->sales->name }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Customer &
                                                                Company
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->name }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->company }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Phonne &
                                                                Email</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->phone }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->email }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Telp</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->company_phone }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Subject</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->subject }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Due Date</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->due_date }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Grade</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->grade }} %"
                                                                    readonly>
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
                                                <h5>Document List</h5>
                                                @if ($query->sales_order->inquiry->files)
                                                    <?php
                                                    $files = json_decode($query->sales_order->inquiry->files);
                                                    if ($files) {
                                                    $fileName = $files[0]->filename;
                                                    ?>
                                                    <a href="{{ url('') }}/file/show/inquiry/{{ $query->sales_order->inquiry->visit->uuid }}/{{ $fileName }}"
                                                        target="_blank" file="">
                                                        <i class="fa fa-eye"></i>
                                                        Show File
                                                    </a>
                                                    <?php
                                                    }
                                                    ?>
                                                @endif
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
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-vcenter table-bordered w-100"
                                                style="font-size:13px" list_products>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 2%;">No.</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Material Desc</th>
                                                        <th class="text-center">Size</th>
                                                        <th class="text-center" style="width: 10%;">QTY</th>
                                                        <th class="text-center" style="width: 10%;">Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
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
                                                <div>{!! $query->sales_order->inquiry->description !!}</div>
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
                                                        value="{{ old('due_date', date('Y-m-d', strtotime($query->due_date))) }}"
                                                        required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Delivery Term
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="delivery_term"
                                                        value="{{ old('delivery_term', $query->delivery_term) }}"
                                                        required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Validity
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="validity"
                                                        value="{{ old('validity', $query->validity) }}"
                                                        required="">
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
                                                                {{ $itemKey === old('payment_term', $query->payment_term) ? 'selected' : '' }}>
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
                                                                {{ $itemKey === old('vat', $query->vat) ? 'selected' : '' }}>
                                                                {{ $itemValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">
                                                        Document
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="attachment"
                                                        value="{{ old('attachment', $query->attachment) }}"
                                                        required="">
                                                </div>
                                            </div>
                                        </div>

                                        @if ($query->status === 'Revision')
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Revision Note</label>
                                                        <textarea class="form-control" disabled rows="5">{{ $query->revision_note }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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

            const listProductTable = $('[list_products]').DataTable({
                order: [
                    [1, 'asc']
                ],
                data: [
                    @foreach ($query->quotation_items as $item)
                        {
                            item_name: "{{ $item->inquiry_product->item_name }}",
                            description: "{{ $item->inquiry_product->description }}",
                            size: "{{ $item->inquiry_product->size }}",
                            qty: "{{ $item->inquiry_product->sourcing_qty }}",
                            remark: "{{ $item->inquiry_product->remark }}",
                        },
                    @endforeach
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
                data: [
                    @foreach ($query->quotation_items as $item)
                        {
                            uuid: "{{ $item->inquiry_product->uuid }}",
                            item_name: "{{ $item->inquiry_product->item_name }}",
                            description: "{{ $item->inquiry_product->description }}",
                            size: "{{ $item->inquiry_product->size }}",
                            qty: "{{ $item->inquiry_product->sourcing_qty }}",
                            sourcing_qty: "{{ $item->inquiry_product->sourcing_qty }}",
                            remark: "{{ $item->inquiry_product->remark }}",
                            delivery_time: "{{ $item->inquiry_product->delivery_time }}",
                            original_cost: "{{ $item->inquiry_product->cost }}",
                            cost: "{{ is_array(old('item')) ? str_replace(',', '.', str_replace('.', '', old('item')[$item->inquiry_product->uuid]['cost'])) : $item->cost }}",
                        },
                    @endforeach
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
                        data: 'original_cost',
                        className: 'text-right align-top',
                        render: function(data, type, row, meta) {
                            return handleCurrencyFormat(Number(row.original_cost));
                        },
                    },
                    {
                        data: 'cost',
                        className: 'align-top p-2',
                        render: function(data, type, row, meta) {
                            return `
                                <input type="hidden" name="item[${row.uuid}][original_cost]" placeholder="" value="${Number(row.original_cost).toFixed(2)}">
                                <input type="text" class="form-control form-control-sm w-100" name="item[${row.uuid}][cost]" placeholder="" value="${handleRupiahFormat(Number(row.cost).toString().replace(/\./g, ','))}" autocomplete="one-time-code" style="min-width: 125px;" number_format>
                                <span class="d-block small text-left text-danger mt-1" style="line-height: 1.25em;" number_format_validation></span>
                            `;
                        }
                    },
                    {
                        data: 'total',
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
                    $(nRow).attr('data-original_cost', aData.original_cost);
                },
            });

            $(document).on("input", "[number_format]", function() {
                const row = $(this).closest('tr');

                this.value = handleRupiahFormat(this.value);
                if (handleSetNumber(this.value) < row.data('original_cost')) {
                    row.find(`[number_format_validation]`).html(
                        `Nilai tidak boleh lebih kurang dari <span class="text-nowrap">${handleCurrencyFormat(Number(row.data('original_cost')))}</span>`
                    );
                } else {
                    row.find(`[number_format_validation]`).html('');
                }

                row.find(`[total_cost]`).html(
                    handleCurrencyFormat(
                        row.data('quantity') *
                        handleSetNumber(this.value)
                    )
                );
            });
        </script>
    </x-slot>
</x-app-layout>
