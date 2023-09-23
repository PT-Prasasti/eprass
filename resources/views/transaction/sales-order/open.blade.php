<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('transaction.sourcing-item.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4><b>Sales Order : {{ $so->id }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Data
                    </button>
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
                                <a class="nav-link" href="#btabs-static-review">Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-static-doc">Document</a>
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
                                                                <select class="form-control" name="so" disabled>
                                                                    <option value="{{ $so->uuid }}" selected>
                                                                        {{ $so->id }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Sales Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name="sales" value="" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Customer & Company
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name="customer" value="" readonly>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name="company" value="" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Phone & Email</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name="phone" value="" disabled>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name="email" value="" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Telp</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name="company_phone" value="" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Subject</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name="subject" value="" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Due Date</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name="due_date" value="" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Grade</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name="grade" value="" disabled>
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
                                                <ul class="list-group">

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-pattern">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Product List</h5>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="push">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Button group with nested dropdown">
                                                        <div class="btn-group" role="group">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                id="btnGroupDrop1" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">Download
                                                                Product List</button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"
                                                                x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <a class="dropdown-item" id="download-excel"
                                                                    href="javascript:void(0)">
                                                                    Excel
                                                                </a>
                                                                <a class="dropdown-item" id="download-pdf"
                                                                    href="javascript:void(0)">
                                                                    PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-vcenter js-dataTable-simple"
                                            style="font-size:13px">
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
                                            <tbody id="tbody">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
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
                                                <div id="note"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                                <div class="text-right">
                                    <div class="push">
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            {{-- <button type="button" class="btn btn-primary">Time</button>
                                        <button type="button" class="btn btn-primary">Price</button>
                                        <button type="button" class="btn btn-primary">Desc</button> --}}
                                            <a href="/" class="btn btn-primary">Add Supplier</a>
                                            <a href="/" class="btn btn-warning">Upload File Excel</a>
                                            <a href="/" class="btn btn-info">Download Format Excel</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="viewTable" class="table-responsive">
                                    <table id="data_table"
                                        class="table table-striped table-vcenter table-bordered js-dataTable-full"
                                        style="font-size:10px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Item Desc</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Supplier</th>
                                                <th class="text-center"><i class="fa fa-gear"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                                <div class="row" id="file-manager">
                                    <div class="col-md-12 py-5 text-center">
                                        <p>File / Folder not Found!</p>
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
            var uuid = ''

            $(document).ready(function() {
                let totalRows = 0
                dataTable()
                getSODetail('{{ $so->uuid }}')
                dataTable($('select[name=so]').val())
                getStorage($('select[name=so]').val())

                $('select[name=supplier]').select2()
                $('select[name=supplier]').change(function() {
                    for (let i = 1; i <= totalRows; i++) {
                        $('input[data-index="' + i + '"]').prop('disabled', false);
                        $('select[data-index="' + i + '"]').prop('disabled', false);
                    }
                })
            })

            function dataTable(inquiry = null) {
                $('#viewTable').html('')
                $('#viewTable').html(`
                    <table id="data_table"
                        class="table table-striped table-vcenter table-bordered js-dataTable-full" style="font-size:10px; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Item Desc</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center"><i class="fa fa-gear"></i></th>
                            </tr>
                        </thead>
                    </table>
                `)
                const table = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    columnDefs: [{
                            targets: 0,
                            width: '10%'
                        }, // Kolom ke-0
                        {
                            targets: 1,
                            width: '35%'
                        }, // Kolom ke-1
                        {
                            targets: 2,
                            width: '15%'
                        }, // Kolom ke-2
                        {
                            targets: 3,
                            width: '30%'
                        }, // Kolom ke-3
                        {
                            targets: 4,
                            width: '10%'
                        } // Kolom ke-4
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sales-order.review_get_data') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "inquiry": inquiry
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: '8%',
                            className: 'text-center'
                        },
                        {
                            data: 'item_desc',
                            className: 'text-center'
                        },
                        {
                            data: 'qty',
                            className: 'text-center'
                        },
                        {
                            data: "supplier",
                            className: 'text-center',
                            render: function(data, type, row) {
                                const selectElement = $(
                                    '<select class="form-control" name="supplier" data-index="' + row
                                    .DT_RowIndex + '">');

                                // Ubah data supplier dari string JSON menjadi objek jika diperlukan
                                let supplierData = data;
                                if (typeof data === 'string') {
                                    try {
                                        supplierData = JSON.parse(data);
                                    } catch (e) {
                                        console.error('Error parsing supplier data:', e);
                                    }
                                }

                                // Pastikan supplierData adalah array objek dan memiliki properti yang benar
                                if (Array.isArray(supplierData) && supplierData.length > 0 && supplierData[0]
                                    .hasOwnProperty('id') && supplierData[0].hasOwnProperty('company')) {
                                    // Jika hanya ada satu supplier, set langsung nilainya
                                    if (supplierData.length === 1) {
                                        selectElement.append('<option value="' + supplierData[0].id +
                                            '" selected>' + supplierData[0].company + '</option>');
                                    } else {
                                        // Jika ada lebih dari satu supplier, tambahkan opsi-opsi
                                        selectElement.append(
                                            '<option selected disabled>Please select</option>');

                                        // Loop melalui setiap objek supplier dan tambahkan opsi
                                        supplierData.forEach(function(supplier) {
                                            selectElement.append('<option value="' + supplier.id +
                                                '">' + supplier.company + '</option>');
                                        });
                                    }
                                }

                                return selectElement.prop('outerHTML');
                            }
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <button id="btnSaveSupplier" class="btn btn-success btn-sm" onclick="saveSupplier('${row.uuid}', '${row.DT_RowIndex}')"><i class="fa fa-save"></i></button>
                                `;
                            }
                        }
                    ],
                    "language ": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                })
                table.on('draw.dt', function() {
                    totalRows = table.rows().count();
                });
            }

            function listSO() {
                var url = "{{ route('transaction.sourcing-item.sales-order') }}"
                $.get(url, function(response) {
                    $('select[name=so]').html('')
                    var element = ``
                    element += `<option selected disabled>Please select</option>`
                    $.each(response, function(index, value) {
                        element += `<option value="` + value.uuid + `">` + value.id + `</option>`
                    })
                    $('select[name=so]').append(element)
                })
            }

            function getSODetail(id) {
                var url = "{{ route('transaction.sourcing-item.so-detail', ['id' => ':id']) }}"
                url = url.replace(':id', id)
                $.get(url, function(response) {
                    $('input[name=sales]').val(response.sales)
                    $('input[name=customer]').val(response.customer)
                    $('input[name=company]').val(response.company)
                    $('input[name=phone]').val(response.phone)
                    $('input[name=email]').val(response.email)
                    $('input[name=company_phone]').val(response.company_phone)
                    $('input[name=subject]').val(response.subject)
                    $('input[name=due_date]').val(response.due_date)
                    $('input[name=grade]').val(response.grade)
                    $('#note').html(``)
                    $('#note').html(response.note)
                    uuid = ''
                    uuid = response.uuid
                    getPdf(id)
                    getProductList(id)
                })
            }

            function getPdf(id) {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.get-pdf') }}",
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

            function listItemPdf(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    var visit = $('select[name=so]').val()
                    $.each(data, function(index, value) {
                        element += `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/inquiry/${uuid}/${value.filename}" target="_blank">` +
                            number + `. ` + value.aliases + `</a>
                                        </div>
                                    </li>`
                        number++
                    })
                    $('.list-group').html(``)
                    $('.list-group').html(element)
                }
            }

            function getProductList(id) {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.get-product') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        listItemTable(response.status, response.data)
                        $('#download-excel').attr('href', '/transaction/sales-order/download/product-list/excel/' +
                            response.uuid)
                        $('#download-pdf').attr('href', '/transaction/sales-order/download/product-list/pdf/' +
                            response.uuid)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function listItemTable(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    $.each(data, function(index, value) {
                        element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td>${value[0]}</td>
                                        <td>${value[1]}</td>
                                        <td class="text-center">${value[2]}</td>
                                        <td class="text-center">${value[3]}</td>
                                        <td class="text-center">${value[4]}</td>
                                    </tr>`
                        number++
                    })
                    $('#tbody').html(``)
                    $('#tbody').html(element)
                }
            }

            function getStorage(inquiry = null) {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.get-storage') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        inquiry: inquiry
                    },
                    success: function(response) {
                        $('#file-manager').html(``)
                        $('#file-manager').html(`
                            <div class="col-md-12 py-5 mb-5">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newFolder"><i class="fa fa-plus"></i> New Folder</button>
                                <button type="button" id="deleteFileFolder" class="btn btn-danger" hidden><i class="fa fa-trash"></i> Delete</button>
                            </div>

                            <div class="modal fade" id="newFolder" tabindex="-1" aria-labelledby="newFolderLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newFolderLabel">Create New Folder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input name="nameFolder" id="nameFolder" type="text" class="form-control" placeholder="Folder Name">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="saveNewFolder()">Save changes</button>
                                    </div>
                                    </div>
                                </div> 
                            </div>
                        `)
                        $.each(response.data, function(index, item) {
                            let html = ''
                            if (item.type == 'file') {
                                html = `
                                    <div class="col-md-3 text-center">
                                        <a href="${item.url}" target="_blank" class="btn">
                                            <i class="fa fa-file" style="color:#2481b3; font-size: 130px;"></i>
                                        </a>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input class="custom-control-input" type="checkbox" name="f${index + 1}"
                                                id="f${index + 1}" data-file="${item.name}" value="">
                                            <label class="custom-control-label" for="f${index + 1}">${item.name}</label>
                                    </div>
                                    `
                            } else {
                                html = `
                                    <div class="col-md-3 text-center">
                                        <button type="button" class="btn" data-toggle="modal"
                                            data-target="#modal-f${index + 1}">
                                            <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                        </button>
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input class="custom-control-input" type="checkbox" name="f${index + 1}"
                                                id="f${index + 1}" data-file="${item.name}" value="">
                                            <label class="custom-control-label" for="f${index + 1}">${item.name}</label>
                                    </div>
                                    `
                            }
                            $(document).on('click', `#f${index + 1}`, function() {
                                // console.log($(this).data('file'))
                                if ($('input[name^=f]:checked').length > 0) {
                                    $('#deleteFileFolder').removeAttr('hidden');

                                    $('#deleteFileFolder').click(function() {
                                        let file = []
                                        $('input[name^=f]:checked').each(function() {
                                            file.push($(this).data('file'))
                                        })
                                        deleteSelectedFileFolder(file)
                                    })
                                } else {
                                    $('#deleteFileFolder').attr('hidden', true);
                                }
                            })
                            $('#file-manager').append(html)
                        })
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function saveNewFolder() {
                let folderName = $('#nameFolder').val()
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.save-folder') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        inquiry: $('select[name=so]').val(),
                        folderName: folderName
                    },
                    success: function(response) {
                        console.log(response)
                        $('#newFolder').val('')
                        $('#newFolder').modal('hide')
                        getStorage($('select[name=so]').val())
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function deleteSelectedFileFolder(file) {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.delete-file-folder') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        inquiry: $('select[name=so]').val(),
                        file: file
                    },
                    success: function(response) {
                        console.log(response)
                        getStorage($('select[name=so]').val())
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }
        </script>
    </x-slot>

</x-app-layout>
