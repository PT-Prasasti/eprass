<x-app-layout>
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Check Mark</h5>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="button" class="btn btn-primary mr-5 mb-5" id="btn-save-data" disabled>
                        <i class="fa fa-save mr-5"></i>Save Data
                    </button>
                </div>

                <div class="col-lg-12">
                    <div class="block">
                        <div class="block-content tab-content">
                            <div class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3" for="example-select">PO Supplier
                                                        Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" id="po-supplier-number"
                                                            name="po_supplier_number">
                                                            <option selected disabled>Please select</option>
                                                            @foreach (\App\Models\PurchaseOrderSupplier::orderBy('transaction_code', 'ASC')->get() as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->transaction_code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Supplier Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="supplier_name"
                                                            value="" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Date</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" name="date"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Note</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control" name="note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-file">
                                            <input type="hidden" name="document_list" value="">
                                            <input type="file" id="upload-document" name="upload_document"
                                                class="custom-file-input js-custom-file-input-enabled"
                                                data-toggle="custom-file-input" accept="application/pdf">
                                            <label id="upload-document-label" for="upload-document"
                                                class="custom-file-label">
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
                                                    <div class="spinner-border spinner-border-sm text-info"
                                                        role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                                <ul class="list-group" document_list=""></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List</h5>
                                    </div>
                                </div>
                                <div id="container-table">
                                    <table class="table table-bordered table-vcenter js-dataTable-simple"
                                        style="font-size:13px" id="dt-product-list">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="modal_2" tabindex="-1" role="dialog"
                                    aria-labelledby="modal-slideup" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Status</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="document_list" value="">
                                                        <input type="file" id="upload-document"
                                                            name="upload_document"
                                                            class="custom-file-input js-custom-file-input-enabled"
                                                            data-toggle="custom-file-input" accept="application/pdf">
                                                        <label id="upload-document-label" for="upload-document"
                                                            class="custom-file-label">
                                                            Choose file
                                                        </label>
                                                    </div>

                                                    <div class="block block-rounded mt-3">
                                                        <div class="block-content block-content-full bg-pattern p-0">
                                                            <h5 class="mb-2">Document List</h5>
                                                            <div class="d-none align-items-center"
                                                                id="upload-document-loading">
                                                                <div class="mr-2">
                                                                    <span>Uploading file</span>
                                                                </div>
                                                                <div class="spinner-border spinner-border-sm text-info"
                                                                    role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
                                                            <ul class="list-group" document_list=""></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-alt-success"
                                                    data-dismiss="modal">
                                                    <i class="fa fa-save"></i> Save Status
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_1" tabindex="-1" role="dialog"
                                    aria-labelledby="modal-slideup" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Status</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="example-select"
                                                                name="example-select">
                                                                <option value="0">Please select</option>
                                                                <option value="1">Good</option>
                                                                <option value="2">Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-alt-success"
                                                    data-dismiss="modal">
                                                    <i class="fa fa-save"></i> Save Status
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
    </main>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                $('select[name="po_supplier_number"]').on('change', function() {
                    let id = $(this).val();
                    $.ajax({
                        url: "{{ route('logistic.good_received.get_supplier') }}",
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('input[name="supplier_name"]').val(response.company);
                            $('input[name="date"]').val(response.transaction_date);
                            $('textarea[name="note"]').val(response.note);
                            $('#btn-save-data').prop('disabled', false);

                            dataTable(response.id);
                        }
                    });
                });

                $('#btn-save-data').on('click', function() {
                    saveData();
                });
            })

            function dataTable(po_supplier_number) {
                $('#container-table').html('');

                $('#container-table').html(`
                    <table class="table table-bordered table-vcenter js-dataTable-simple"
                                            style="font-size:13px" id="dt-product-list">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                    </table>
                `)

                $('#dt-product-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('logistic.good_received.get_product') }}",
                        type: 'GET',
                        data: {
                            id: po_supplier_number
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'item_name',
                            name: 'item_name'
                        },
                        {
                            data: 'qty',
                            name: 'qty'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center',
                            render: function(data, type, full, meta) {
                                return `
                                    <button id="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_1">Selected</button>
                                `;
                            }
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center',
                            render: function(data, type, full, meta) {
                                return `
                                    <button id="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_2"> <i class="fa fa-file"></i></button>
                                `;
                            }
                        }
                    ]
                });
            }

            function saveData() {
                let po_supplier_number = $('select[name="po_supplier_number"]').val();
                let supplier_name = $('input[name="supplier_name"]').val();
                let date = $('input[name="date"]').val();
                let note = $('textarea[name="note"]').val();

                $.ajax({
                    url: "{{ route('logistic.good_received.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        purchase_order_supplier_id: po_supplier_number,
                        supplier_name: supplier_name,
                        date: date,
                        note: note,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('logistic.good_received.index') }}";
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
