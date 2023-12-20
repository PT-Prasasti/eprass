<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('crm.inquiry.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">
            <div class="row">
                <div class="col-md-6">
                    <h4><b>Add Inquiry : <span id="id"></span></b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('crm.inquiry.download-template') }}" class="btn btn-info mr-5 mb-5">
                        <i class="fa fa-download mr-5"></i>Download Format Excel
                    </a>
                    <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Inquiry
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full bg-pattern">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">ID Visit</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="visit">
                                                <option value="0" selected disabled>Please select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Due Date *</label>
                                        <input type="date"
                                            class="form-control @error('due_date') is-invalid @enderror" name="due_date"
                                            value="{{ old('due_date') }}" required>
                                        @error('due_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Subject *</label>
                                        <input type="text"
                                            class="form-control @error('subject') is-invalid @enderror" name="subject"
                                            value="{{ old('subject') }}" required>
                                        @error('subject')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12">Grade Inquiry *</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="js-rangeslider" id="example-rangeslider1"
                                                name="grade" value="{{ old('grade') }}" required>
                                        </div>
                                        @error('grade')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">Company Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="company" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <input type="text" class="form-control" name="customer" disabled>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Telp.</label>
                                            <input type="text" class="form-control" name="telp" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Phone / HP</label>
                                            <input type="text" class="form-control" name="phone" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="example-file-input-custom" name="upload-pdf"
                            data-toggle="custom-file-input" accept="application/pdf" disabled>
                        <label class="custom-file-label" for="example-file-input-custom" id="upload-pdf-label">Choose
                            file</label>
                    </div>
                    <div class="block block-rounded mt-3">
                        <div class="block-content block-content-full bg-pattern">
                            <h5>Document List</h5>
                            <div class="d-none align-items-center" id="loading-file">
                                <div class="mr-2">
                                    <span>Uploading file</span>
                                </div>
                                <div class="spinner-border spinner-border-sm text-info" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <ul class="list-group">

                            </ul>
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
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-primary mr-5 mb-5" id="upload-product"
                                data-toggle="modal" data-target="#modal-slideup" disabled>
                                <i class="fa fa-upload mr-5"></i>Upload Files
                            </button>
                            <button type="button" onclick="addListTable()" id="new-list"
                                class="btn btn-success mr-5 mb-5" disabled>
                                <i class="fa fa-plus mr-5"></i>Add List
                            </button>
                            <button type="button" onclick="removeLastRow()" id="remove-list"
                                class="btn btn-danger mr-5 mb-5" disabled>
                                <i class="fa fa-plus mr-5"></i>Remove List
                            </button>
                        </div>
                        <div class="modal fade" id="modal-slideup" tabindex="-1" role="dialog"
                            aria-labelledby="modal-slideup" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-slideup" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h3 class="block-title">Upload File Inquiry</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="upload-excel" name="upload-excel"
                                                            data-toggle="custom-file-input">
                                                        <label class="custom-file-label" id="upload-excel-label"
                                                            for="upload-excel">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-alt-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="uploadExcel()" class="btn btn-alt-primary">
                                            <i class="fa fa-check"></i> Upload Files
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div id="example"></div>
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
                            <textarea name="description" class="js-summernote"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="pdf">
        </form>

    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                generateId()
                listVisit()
                $('select[name=visit]').select2()
                $('select[name=visit]').change(function() {
                    getVisitDetail($(this).val())
                    $('input[type=file]').attr('disabled', false)
                    $('#upload-product').attr('disabled', false)
                    $('#new-list').attr('disabled', false)
                    $('#remove-list').attr('disabled', false)
                    getPdf($(this).val())
                    getProductList($(this).val())
                })
                $('input[name=upload-pdf]').change(function() {
                    $('#loading-file').removeClass('d-none')
                    $('#loading-file').addClass('d-flex')
                    uploadPdf($(this).prop('files')[0])
                })
                initProductListTable()
            })

            function generateId() {
                var url = "{{ route('crm.inquiry.id') }}"
                $.get(url, function(response) {
                    $('input[name=id]').val(response)
                    $('#id').html(response)
                })
            }

            function listVisit() {
                var url = "{{ route('crm.inquiry.visit') }}"
                $.get(url, function(response) {
                    console.log(response);
                    $('select[name=visit]').html('')
                    var element = ``
                    element += `<option selected disabled>Please select</option>`
                    $.each(response, function(index, value) {
                        element += `<option value="` + value.uuid + `">` + value.id + `</option>`
                    })
                    $('select[name=visit]').append(element)
                })
            }

            function getVisitDetail(id) {
                var url = "{{ route('crm.inquiry.visit-detail', ['id' => ':id']) }}"
                url = url.replace(':id', id)
                $.get(url, function(response) {
                    $('input[name=company]').val(response.company)
                    $('input[name=customer]').val(response.customer)
                    $('input[name=telp]').val(response.telp)
                    $('input[name=phone]').val(response.phone)
                    $('input[name=email]').val(response.email)
                })
            }

            function getPdf(id) {
                $.ajax({
                    url: "{{ route('crm.inquiry.get-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function uploadPdf(file) {
                const formData = new FormData()
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('file', file)
                formData.append('so', $('select[name=visit]').val())
                $.ajax({
                    url: '{{ route('crm.inquiry.upload-pdf') }}',
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

            function listItemPdf(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    var visit = $('select[name=visit]').val()
                    $.each(data, function(index, value) {
                        element += `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/temp/${visit}/${value.filename}" target="_blank">` +
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

            function deletePdf(file) {
                $.ajax({
                    url: "{{ route('crm.inquiry.delete-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        file: file,
                        so: $('select[name=visit]').val()
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            let productListTable

            function initProductListTable(data = null) {
                const container = document.querySelector('#example')
                let newData

                if (data == null) {
                    newData = [
                        [null, null, null, null, null, null],
                    ];
                } else {
                    newData = data;
                }

                if (productListTable) {
                    productListTable.destroy();
                }

                var fullWidth = container.offsetWidth;
                fullWidth = fullWidth - 50;

                var itemWidth = fullWidth * 0.25;
                var descWidth = fullWidth * 0.25;
                var sizeWidth = fullWidth * 0.20;
                var qtyWidth = fullWidth * 0.10;
                var remarkWidth = fullWidth * 0.20;

                var columnWidth = [itemWidth, descWidth, sizeWidth, qtyWidth, remarkWidth];

                productListTable = new Handsontable(container, {
                    data: newData,
                    rowHeaders: true,
                    colHeaders: ['ITEM NAME', 'MATERIAL DESCRIPTION', 'SIZE', 'QTY', 'REMARK'],
                    width: '100%',
                    height: 'auto',
                    rowHeights: 23,
                    colWidths: columnWidth,
                    licenseKey: 'non-commercial-and-evaluation',
                    hiddenColumns: {
                        // specify columns hidden by default
                        columns: [5],
                    },
                    rowClassName: 'custom-row-style',
                    afterChange: (changes) => {
                        changes?.forEach(([row, prop, oldValue, newValue]) => {
                            const tableData = productListTable.getData()
                            storeProduct(tableData)
                        });
                    }
                })
            }

            function addListTable() {
                const tableData = productListTable.getData()
                tableData.push([])
                initProductListTable(tableData)
            }

            function removeLastRow() {
                const tableData = productListTable.getData();

                if (tableData.length > 1) { // Pastikan ada baris yang bisa dihapus
                    tableData.pop(); // Menghapus baris terakhir
                    initProductListTable(tableData); // Memperbarui tabel dengan data yang diperbarui


                }
            }

            function uploadExcel() {
                const formData = new FormData()
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('file', $('#upload-excel')[0].files[0])
                formData.append('so', $('select[name=visit]').val())
                $.ajax({
                    url: '{{ route('crm.inquiry.upload-excel') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        getProductList($('select[name=visit]').val())
                        $('#modal-slideup').modal('toggle')
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
                $('#upload-excel-label').html('Choose file')
            }

            function getProductList(id) {
                $.ajax({
                    url: "{{ route('crm.inquiry.get-product') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        initProductListTable(response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function storeProduct(data) {
                $.ajax({
                    url: "{{ route('crm.inquiry.store-product') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: $('select[name=visit]').val(),
                        data: data
                    },
                    success: function(response) {
                        getProductList($('select[name=visit]').val())
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }
        </script>
    </x-slot>

</x-app-layout>
