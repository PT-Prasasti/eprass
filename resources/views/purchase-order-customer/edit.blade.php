<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('purchase-order-customer.update', $query->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Edit PO Customer: {{ $query->quotation->quotation_code }}</b></h4>
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
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->quotation_code }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Sales Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->sales->name }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Customer & Company Name
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->visit->customer->name }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->visit->customer->company }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Phonne & Email</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->visit->customer->phone }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->visit->customer->email }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Telp</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->visit->customer->company_phone }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Subject</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name=""
                                                            value="{{ $query->quotation->sales_order->inquiry->subject }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="purchase_order_number"
                                                            value="{{ old('purchase_order_number', $query->purchase_order_number) }}"
                                                            autocomplete="one-time-code">
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
                                        @include('transaction.quotation.partials.print_body', [
                                            'query' => $query->quotation,
                                            'printDate' => $query->quotation->created_at,
                                        ])
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
                data: {!! $query->quotation->quotation_items->toJson() !!},
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
                                <input type="text" class="form-control form-control-sm w-100" name="item[${row.id}][delivery_time]" placeholder="" value="${row.delivery_time_of_purchase_order_customer ?? ''}" autocomplete="one-time-code" style="min-width: 100px;">
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
        </script>
    </x-slot>
</x-app-layout>
