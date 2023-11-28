<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('purchase-order-supplier.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>{{ $transactionCode }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary mr-5 mb-5" data-toggle="modal" data-target="#modal-slideup">
                        <i class="fa fa-plus mr-5"></i>Select SO
                    </button>
                    <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save 
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
                                <a class="nav-link" href="#document">Document</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#bank">Bank Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pickup">Pick Up Information</a>
                            </li> -->
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row" hidden>
                                    <input type="text" class="form-control" name="sales_order_id" value="" readonly sales_order_id>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">SO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="" readonly sales_order_number>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Subject</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="" readonly sales_order_subject>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-file">
                                            <input type="hidden" name="document_list" value="">
                                            <input type="file" id="upload-document" name="upload_document" class="custom-file-input" data-toggle="custom-file-input" accept="application/pdf">
                                            <label id="upload-document-label" for="upload-document" class="custom-file-label">
                                                Choose file
                                            </label>
                                        </div>

                                        <div class="block block-rounded mt-3">
                                            <div class="block-content block-content-full bg-pattern p-0">
                                                <h5 class="mb-2">Document List</h5>
                                                <div class="d-none align-items-center" id="upload-document-loading">
                                                    <div class="mr-2">
                                                        <span>Uploading file</span>
                                                    </div>
                                                    <div class="spinner-border spinner-border-sm text-info" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                                <ul class="list-group" document_list></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List</h5>
                                    </div>
                                </div>
                                <table class="table table-bordered table-center" selected_sales_order_items>
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Supplier Name</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Delevery Time</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center">
                                            <input type="text" class="form-control" name="total_shipping_note" value="Shipping Fee (to Prasasti's Werehouse)" autocomplete="one-time-code">
                                        </th>
                                        <th class="text-right pr-4">1</th>
                                        <th class="text-right">
                                            <input type="text" class="form-control text-right" name="total_shipping_value" value="" autocomplete="one-time-code" number_format>
                                        </th>
                                        <th class="text-right text-nowrap pt-3" total_shipping_total></th>
                                        <th class="text-center"></th>
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
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="term" class="form-control" required="" autocomplete="one-time-code">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Delivery
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="delivery" class="form-control" required="" autocomplete="one-time-code">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Note
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="note" class="form-control" required="" autocomplete="one-time-code">
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
                                                        <option value="{{ $itemKey }}" {{ $itemKey === old('payment_term') ? 'selected' : '' }}>
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
                                                        <option value="{{ $itemKey }}" {{ $itemKey === old('vat') ? 'selected' : '' }}>
                                                            {{ $itemValue }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Attachment
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="attachment" autocomplete="one-time-code" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="tab-pane" id="bank" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Bank Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="bank_name" class="form-control" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Bank Account
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="bank_account" class="form-control" autocomplete="one-time-code" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Bank Swift / Code
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="bank_swift" class="form-control" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        Bank Number
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="bank_number" class="form-control" autocomplete="one-time-code" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-12">
                                                        Upload Invoice
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-12">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input js-custom-file-input-enabled" id="invoice" name="invoice">
                                                            <label class="custom-file-label" for="invoice">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="document" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f1">INQUIRY</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f2">SALES ORDER</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f3">SOURCING ITEM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f4">PO CUSTOMER</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <label class="custom-control-label" for="f4">PO SUPPLIER</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="pickup" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="last-name-column">Name</label>
                                                    <input type="text" class="form-control" name="name" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Email</label>
                                                    <input type="text" class="form-control" name="email" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone_number" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Mobile Number</label>
                                                    <input type="text" class="form-control" name="mobile_number" required="">
                                                </div>
                                                <div clasa="form-group">
                                                    <label for="last-name-column">Pick Up Address</label>
                                                    <textarea class="form-control" id="" name="pickup_adress" rows="4"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col-12">Upload Doc. Pick Up Information</label>
                                                    <div class="col-12">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input js-custom-file-input-enabled" id="example-file-input-custom" name="dokumen_pickup" data-toggle="custom-file-input">
                                                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modal-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-slideup" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Select Data SO</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div hidden>
                            <input type="text" class="form-control" value="" selected_sales_order_number>
                            <input type="text" class="form-control" value="" selected_sales_order_subject>
                        </div>
                        <div class="form-group row">
                            <label class="col-12" for="example-select">SO Number :</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="selected_sales_order" required="">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h5>Product List</h5>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered table-center w-100" style="font-size:11px" sales_order_selected_items>
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Supplier</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Delevery Time</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal" set_seles_order>
                        <i class="fa fa-plus"></i>
                        Add Data
                    </button>
                </div>
            </div>
        </div>
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

            const salesOrderSelectedItemTable = $('[sales_order_selected_items]').DataTable({
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
                        data: 'sourcing_supplier.company',
                        className: 'align-top',
                    },
                    {
                        data: 'item_name',
                        className: 'align-top',
                        render: function(data, type, row, meta) {
                            return `
                                ${row.sourcing_supplier.item_name}
                                <br/>${row.sourcing_supplier.description}
                                <br/>${row.sourcing_supplier.inquiry_product.size}
                                <br/>${row.sourcing_supplier.inquiry_product.remark}
                            `;
                        },
                    },
                    {
                        data: 'sourcing_supplier.qty',
                        className: 'align-top text-right',
                    },
                    {
                        data: 'sourcing_supplier.unitprice',
                        className: 'align-top text-right',
                        render: function(data, type, row, meta) {
                            return `<span class="text-nowrap">${handleCurrencyFormat(Number(row.sourcing_supplier.unitprice))}</span>`;
                        },
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-top text-right',
                        render: function(data, type, row, meta) {
                            return `<span class="text-nowrap">${handleCurrencyFormat(Number(row.sourcing_supplier.qty*row.sourcing_supplier.unitprice))}</span>`;
                        }
                    },
                    {
                        data: 'sourcing_supplier.dt',
                        className: 'align-top',
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-top text-center',
                        render: function(data, type, row, meta) {
                            return `
                            <label class="css-control css-control-info css-checkbox">
                                <input type="checkbox" name="sales_order_selected_item[${row.uuid}]" class="css-control-input">
                                <span class="css-control-indicator"></span>
                            </label>
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

            const handleSetSalesOrder = (data) => {
                salesOrderSelectedItemTable.clear().draw();
                salesOrderSelectedItemTable.rows.add(data.sourcing.selected_sourcing_suppliers ?? []).draw(true);

                $(`[selected_sales_order_number]`).val(data.id);
                $(`[selected_sales_order_subject]`).val(data.inquiry.subject);
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

            const handleListDocument = (data) => {
                var element = ``;
                var iteration = 1;
                $.each(data, function(index, value) {
                    element += `
                        <li class="list-group-item" data-id="${value.filename}">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/files/purchase-order-suppliers/${value.filename}" target="_blank">${iteration + '. ' + value.aliases}</a>
                                <button type="button" class="btn btn-link text-danger" style="padding: 0; width: auto; height: auto;" remove_document>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    `;

                    iteration++;
                });

                $(`[document_list]`).html(``);
                $(`[document_list]`).html(element);
                $(`input[name="document_list"]`).val(JSON.stringify(data));
            }

            const handleUploadDocument = async (file) => {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('file', file);
                formData.append('other_files', $(`[name="document_list"]`).val());

                await $.ajax({
                    url: `{{ route('purchase-order-supplier.upload-document') }}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#upload-document-loading').removeClass('d-flex');
                        $('#upload-document-loading').addClass('d-none');

                        if (res.status === 200) {
                            handleListDocument(res.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                await $(`#upload-document-label`).html('Choose file');
            }

            $(`[name="selected_sales_order"]`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('purchase-order-supplier.search.sales-order') }}`,
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
                                    // disabled: object.status != 'Done' || object.purchase_order_customer,
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

            $(document).on('select2:selecting', `[name="selected_sales_order"]`, function(e) {
                const data = e.params.args.data.data;
                handleSetSalesOrder(data);
            });

            $(document).on('click', `[set_seles_order]`, function() {
                var selectedSalesOrderItemsElement = $(`[selected_sales_order_items] > tbody`);
                if ($(`[sales_order_id]`).val() !== $(`[name="selected_sales_order"]`).val()) {
                    selectedSalesOrderItemsElement.html('');
                    selectedSalesOrderItemsElement = $(`[selected_sales_order_items] > tbody`);
                }

                $(`[sales_order_id]`).val($(`[name="selected_sales_order"]`).val());
                $(`[sales_order_number]`).val($(`[selected_sales_order_number]`).val());
                $(`[sales_order_subject]`).val($(`[selected_sales_order_subject]`).val());

                var selectedSalesOrderItems = [];
                if (selectedSalesOrderItemsElement.children().length > 0) {
                    selectedSalesOrderItemsElement.children().map((index, row) => {
                        selectedSalesOrderItems.push($(row).data('id'));
                    });
                }

                if (salesOrderSelectedItemTable.rows().data().length > 0) {
                    var iteration = selectedSalesOrderItems.length;
                    salesOrderSelectedItemTable.rows().data().map((data, index) => {
                        if ($(`[name="sales_order_selected_item[${data.uuid}]"]`).is(":checked")) {
                            if (!selectedSalesOrderItems.includes(data.uuid)) {
                                selectedSalesOrderItemsElement.append(`
                                    <tr data-id="${data.uuid}">
                                        <td class="align-top text-center pt-3" iteration>
                                            <p>${iteration+=1}</p>
                                        </td>
                                        <td class="align-top pt-3">
                                            ${data.sourcing_supplier.company}
                                        </td>
                                        <td class="align-top pt-3 pb-3"  style="min-width: 250px;">
                                            ${data.sourcing_supplier.item_name}
                                            <br/>${data.sourcing_supplier.description}
                                            <br/>${data.sourcing_supplier.inquiry_product.size}
                                            <br/>${data.sourcing_supplier.inquiry_product.remark}
                                        </td>
                                        <td class="align-top pt-3 pr-4 text-right" style="width: 150px;">
                                            ${handleRupiahFormat(data.sourcing_supplier.qty)}
                                            <input type="hidden" class="form-control text-right" name="item[${data.uuid}][quantity]" value="${handleRupiahFormat(data.sourcing_supplier.qty)}" autocomplete="one-time-code" required="" number_format>
                                        </td>
                                        <td class="align-top">
                                            <input type="text" class="form-control text-right" name="item[${data.uuid}][cost]" value="${handleRupiahFormat(data.sourcing_supplier.unitprice)}" autocomplete="one-time-code" required="" number_format>
                                        </td>
                                        <td class="align-top text-right text-nowrap pt-3" price>${handleCurrencyFormat(data.sourcing_supplier.qty*data.sourcing_supplier.unitprice)}</td>
                                        <td class="align-top">
                                            <input type="text" class="form-control" name="item[${data.uuid}][delivery_time]" value="${data.sourcing_supplier.dt}" autocomplete="one-time-code" required="">
                                        </td>
                                    </tr>
                                `);
                            }
                        } else {
                            $(`[data-id="${data.uuid}"]`).remove()
                        }
                    });
                }

                $(`[iteration]`).map((index, row) => {
                    $(row).html(index + 1)
                });
            });

            $(document).on("input", "[number_format]", function() {
                this.value = handleRupiahFormat(handleSetNumber(this.value));

                handleCalculate();
            });

            $(document).on('change', `input[name=upload_document]`, function() {
                $(`#upload-document-loading`).removeClass('d-none');
                $(`#upload-document-loading`).addClass('d-flex');

                handleUploadDocument($(this).prop('files')[0]);
            });

            $(document).on('click', `[remove_document]`, function() {
                const thisList = $(this).closest('li');
                $.ajax({
                    url: "{{ route('purchase-order-supplier.upload-document') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        method: 'DELETE',
                        file_name: thisList.data('id'),
                        other_files: $(`input[name="document_list"]`).val(),
                    },
                    success: function(res) {
                        if (res.status === 200) {
                            handleListDocument(res.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            handleCalculate();

            @if(session('quotation'))
            $(`[name="quotation"]`).select2("trigger", "select", {
                data: {
                    id: `{{ session('quotation')->id }}`,
                    text: `{{ session('quotation')->quotation_code }}`,
                    data: {
                        !!session('quotation') - > toJson() !!
                    }
                }
            });
            @endif
        </script>
    </x-slot>
</x-app-layout>