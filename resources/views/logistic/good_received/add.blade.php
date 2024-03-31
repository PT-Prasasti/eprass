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
                                                            @php
                                                                $items = \App\Models\PurchaseOrderSupplier::orderBy(
                                                                    'transaction_code',
                                                                    'ASC',
                                                                )
                                                                    ->whereNotIn('id', function ($query) {
                                                                        $query
                                                                            ->select('purchase_order_supplier_id')
                                                                            ->from('b_t_b_s');
                                                                    })
                                                                    ->get();
                                                            @endphp

                                                            @foreach ($items as $item)
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
                                            <input type="file" id="upload-document" name="upload-pdf"
                                                class="custom-file-input js-custom-file-input-enabled"
                                                data-toggle="custom-file-input" accept="application/pdf" disabled>
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
                                                        <input type="hidden" name="inquiry_id">
                                                        <input type="file" id="upload-item-file"
                                                            name="upload-item-file"
                                                            class="custom-file-input js-custom-file-input-enabled"
                                                            data-toggle="custom-file-input">
                                                        <label id="upload-document-label" for="upload-document"
                                                            class="custom-file-label">
                                                            Choose file
                                                        </label>
                                                    </div>

                                                    <div class="block block-rounded mt-3">
                                                        <div class="block-content block-content-full bg-pattern p-0">
                                                            <h5 class="mb-2">Document List</h5>
                                                            <div class="d-none align-items-center" id="">
                                                                <div class="mr-2">
                                                                    <span>Uploading file</span>
                                                                </div>
                                                                <div class="spinner-border spinner-border-sm text-info"
                                                                    role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
                                                            <ul class="list-group-items" document_list=""></ul>
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
                                                            <input type="hidden" name="inquiry_product_id">
                                                            <select class="form-control" name="status">
                                                                <option selected disabled>Please select</option>
                                                                <option value="good">Good</option>
                                                                <option value="rejected">Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-alt-success"
                                                    data-dismiss="modal" onclick="saveStatus()">
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

        <input type="hidden" name="pdf">
        <input type="hidden" name="file_items[]">
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
                    getPdf($(this).val());
                    $('input[name=upload-pdf]').prop('disabled', false)
                });

                $('#btn-save-data').on('click', function() {
                    saveData();
                });
                $('input[name=upload-pdf]').change(function() {
                    $('#loading-file').removeClass('d-none')
                    $('#loading-file').addClass('d-flex')
                    uploadPdf($(this).prop('files')[0])
                })
                $('input[name=upload-item-file]').change(function() {
                    $('#loading-file').removeClass('d-none')
                    $('#loading-file').addClass('d-flex')
                    uploadItemFile($(this).prop('files')[0])
                })
            })

            function saveStatus() {
                let po_supplier_number = $('select[name=po_supplier_number]').val();
                let inquiry_product_id = $('input[name="inquiry_product_id"]').val();
                let status = $('select[name="status"]').val();

                $.ajax({
                    url: "{{ route('logistic.good_received.save_status') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        inquiry_product_id: inquiry_product_id,
                        status: status,
                        po_supplier_number: po_supplier_number
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

                            $('#status_' + response.inquiry_product_id).removeClass('btn-secondary')
                            $('#status_' + response.inquiry_product_id).text(response.status_name.toUpperCase())
                            if (response.status_name == 'good') {
                                $('#status_' + response.inquiry_product_id).removeClass('btn-danger')
                                $('#status_' + response.inquiry_product_id).addClass('btn-success')
                            } else {
                                $('#status_' + response.inquiry_product_id).removeClass('btn-success')
                                $('#status_' + response.inquiry_product_id).addClass('btn-danger')
                            }
                        }
                    }
                });
            }

            function inputInquiryProductId(id) {
                $('input[name="inquiry_product_id"]').val('');
                $('input[name="inquiry_product_id"]').val(id);
            }

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
                            data: 'status',
                            name: 'status',
                            className: 'text-center',
                            render: function(data, type, full, meta) {
                                if (data == 'good' || data == 'rejected') {
                                    return `<button id="status_${full.id}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_1" onclick="inputInquiryProductId(${full.id})">${data.toUpperCase()}</button>`
                                } else {
                                    return `<button id="status_${full.id}" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal_1" onclick="inputInquiryProductId(${full.id})">-- Please select --</button>`
                                }
                            }
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center',
                            render: function(data, type, full, meta) {
                                return `
                                    <button id="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_2" onclick="getItemFile('${data}')"> <i class="fa fa-file"></i></button>
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
                let pdf = $('input[name="pdf"]').val();
                let file_items = $('input[name="file_items[]"]').val();

                $.ajax({
                    url: "{{ route('logistic.good_received.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        purchase_order_supplier_id: po_supplier_number,
                        supplier_name: supplier_name,
                        date: date,
                        note: note,
                        pdf: pdf,
                        file_items: file_items
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

            function uploadPdf(file) {
                const formData = new FormData()
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('file', file)
                formData.append('po_supplier_number', $('select[name=po_supplier_number] option:selected').text())
                $.ajax({
                    url: "{{ route('logistic.good_received.upload_pdf') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#loading-file').removeClass('d-flex')
                        $('#loading-file').addClass('d-none')
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
                $('#upload-pdf-label').html('Choose file')
            }

            function uploadItemFile(file) {
                console.log(file)
                const formData = new FormData()
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('file', file)
                formData.append('inquiry_id', $('input[name=inquiry_id]').val())
                formData.append('po_supplier_number', $('select[name=po_supplier_number] option:selected').text())
                $.ajax({
                    url: "{{ route('logistic.good_received.upload_items_file') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#loading-file').removeClass('d-flex')
                        $('#loading-file').addClass('d-none')
                        listItemItemFile(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
                $('#upload-pdf-label').html('Choose file')
            }

            function listItemPdf(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    var po_supplier_number = $('select[name=po_supplier_number] option:selected').text()
                    po_supplier_number = po_supplier_number.replace(/\//g, '_')
                    $.each(data, function(index, value) {
                        element +=
                            `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/temp/${po_supplier_number}/${value.filename}" target="_blank">` +
                            number + `. ` + value.aliases + `</a>
                                            <button type="button" onclick="deletePdf('` + value.filename + `')" class="btn btn-link text-danger" style="padding: 0; width: auto; height: auto;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                </svg>    
                                            </button>
                                        </div>
                                    </li>`
                        number++
                    })
                    $('.list-group').html(``)
                    $('.list-group').html(element)
                    $('input[name=pdf]').val(JSON.stringify(data))
                }
            }

            function listItemItemFile(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    var po_supplier_number = $('select[name=po_supplier_number] option:selected').text()
                    po_supplier_number = po_supplier_number.replace(/\//g, '_')
                    var inquiry_id = $('input[name=inquiry_id]').val()
                    var filename = `${po_supplier_number}+${inquiry_id}`
                    $('#list-group-items').html(``)
                    $.each(data, function(index, value) {
                        element +=
                            `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/temp/${filename}/${value.filename}" target="_blank">` +
                            number + `. ` + value.aliases + `</a>
                                            <button type="button" onclick="deleteItem('` + value.filename + `', 'edit')" class="btn btn-link text-danger" style="padding: 0; width: auto; height: auto;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                </svg>    
                                            </button>
                                        </div>
                                    </li>`
                        number++
                    })
                    $('.list-group-items').html(``)
                    $('.list-group-items').html(element)
                    $('input[name="file_items[]"]').val(JSON.stringify(data))
                }
            }

            function getPdf(id) {
                $.ajax({
                    url: "{{ route('logistic.good_received.get_pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        po_supplier_number: id
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function getItemFile(id) {
                $('input[name=inquiry_id]').val('');
                $.ajax({
                    url: "{{ route('logistic.good_received.get_items_file') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        inquiry_id: id,
                        po_supplier_number: $('select[name=po_supplier_number] option:selected').text()
                    },
                    success: function(response) {
                        $('input[name=inquiry_id]').val(id)
                        listItemItemFile(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function deletePdf(file) {
                $.ajax({
                    url: "{{ route('logistic.good_received.delete_pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        file: file,
                        po_supplier_number: $('select[name=po_supplier_number] option:selected').text()
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function deleteItem(file, edit = null) {
                $.ajax({
                    url: "{{ route('logistic.good_received.delete_items_file') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        file: file,
                        po_supplier_number: $('select[name=po_supplier_number] option:selected').text(),
                        inquiry_id: $('input[name=inquiry_id]').val(),
                        edit: edit
                    },
                    success: function(response) {
                        listItemItemFile(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }
        </script>
    </x-slot>
</x-app-layout>
