<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('transaction.sourcing-item.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4><b>Sourching Item</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    {{-- <button type="submit" class="btn btn-success mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Data
                    </button> --}}
                </div>
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
            </div>
            <div class="col-lg-12">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#btabs-static-home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link review-link" href="#btabs-static-review">Review</a>
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
                                                            <select class="form-control" name="so">
                                                                <option value="0" selected disabled>Please select</option>
                                                            </select>
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
                        </div>
                        <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                            <div class="table-responsive pb-4" id="product-list">
                                
                                
                                
                            </div>
                        </div>
                        <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f1" value="">
                                        <label class="custom-control-label" for="f1">Catalog</label>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f2" value="">
                                        <label class="custom-control-label" for="f2">Drawing</label>
                                    </div>
                                </div>
                                <div id="viewTable">
                                    <table id="data_table"
                                        class="table table-striped table-vcenter table-bordered js-dataTable-full"
                                        style="font-size:10px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">DT</th>
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
                listSO()
                dataTable()
                $('select[name=so]').select2()
                $('select[name=so]').change(function() {
                    getSODetail($(this).val())
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
            })

            function dataTable(inquiry = null) {
                $('#viewTable').html('')
                $('#viewTable').html(`
                    <table id="data_table"
                        class="table table-striped table-vcenter table-bordered js-dataTable-full" style="font-size:10px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">No.</th>
                                <th rowspan="2" class="text-center" style="width: 200px;">Item Desc</th>
                                <th rowspan="2" class="text-center">Qty</th>

                                <th colspan="4" class="text-center bg-primary text-white">
                                    <select name="supplier_1" id="supplier1" class="form-control" data-plugin-selectTwo>
                                        <option value="0" selected disabled>Please select</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company }}</option>
                                    @endforeach    
                                </th>
                                <th colspan="4" class="text-center bg-success text-white">
                                    <select name="supplier_2" id="supplier1" class="form-control" data-plugin-selectTwo>
                                        <option value="0" selected disabled>Please select</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company }}</option>
                                    @endforeach    
                                </th>
                                <th colspan="4" class="text-center bg-warning text-white">
                                    <select name="supplier_3" id="supplier1" class="form-control" data-plugin-selectTwo>
                                        <option value="0" selected disabled>Please select</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company }}</option>
                                    @endforeach    
                                </th>
                                <th colspan="4" class="text-center bg-info text-white">
                                    <select name="supplier_4" id="supplier1" class="form-control" data-plugin-selectTwo>
                                        <option value="0" selected disabled>Please select</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company }}</option>
                                    @endforeach    
                                </th>
                                <th colspan="4" class="text-center bg-secondary text-white">
                                    <select name="supplier_5" id="supplier1" class="form-control" data-plugin-selectTwo>
                                        <option value="0" selected disabled>Please select</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company }}</option>
                                    @endforeach    
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center bg-primary text-white">Description</th>
                                <th class="text-center bg-primary text-white">Qty</th>
                                <th class="text-center bg-primary text-white">Unit Price</th>
                                <th class="text-center bg-primary text-white">DT</th>
                                
                                <th class="text-center bg-success text-white">Description</th>
                                <th class="text-center bg-success text-white">Qty</th>
                                <th class="text-center bg-success text-white">Unit Price</th>
                                <th class="text-center bg-success text-white">DT</th>

                                <th class="text-center bg-warning text-dark">Description</th>
                                <th class="text-center bg-warning text-dark">Qty</th>
                                <th class="text-center bg-warning text-dark">Unit Price</th>
                                <th class="text-center bg-warning text-dark">DT</th>

                                <th class="text-center bg-info text-white">Description</th>
                                <th class="text-center bg-info text-white">Qty</th>
                                <th class="text-center bg-info text-white">Unit Price</th>
                                <th class="text-center bg-info text-white">DT</th>

                                <th class="text-center bg-secondary text-white">Description</th>
                                <th class="text-center bg-secondary text-white">Qty</th>
                                <th class="text-center bg-secondary text-white">Unit Price</th>
                                <th class="text-center bg-secondary text-white">DT</th>
                            </tr>
                        </thead>
                    </table>
                `)
                const table = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    scrollX: true,
                    "paging": true,
                    "order": [
                        [0, "asc"]
                    ],
                    ajax: {
                        "url": "{{ route('transaction.sourcing-item.review_get_data') }}",
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
                            className: 'text-center'
                        }, {
                            data: 'item_desc',
                            className: 'text-center',
                            width: '20%'
                        }, {
                            data: 'qty',
                            className: 'text-center'
                        },

                        {
                            data: "id",
                            className: 'text-center bg-primary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="description_1" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            },
                        }, {
                            data: "id",
                            className: 'text-center bg-primary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="quantity_1" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-primary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="price_1" data-index="' +
                                    row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-primary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="dt_1" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        },

                        {
                            data: "id",
                            className: 'text-center bg-success text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="description_2" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            },
                        }, {
                            data: "id",
                            className: 'text-center bg-success text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="quantity_2" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-success text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="price_2" data-index="' +
                                    row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-success text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="dt_2" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        },

                        {
                            data: "id",
                            className: 'text-center bg-warning text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="description_3" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            },
                        }, {
                            data: "id",
                            className: 'text-center bg-warning text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="quantity_3" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-warning text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="price_3" data-index="' +
                                    row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-warning text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="dt_3" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        },

                        {
                            data: "id",
                            className: 'text-center bg-info text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="description_4" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            },
                        }, {
                            data: "id",
                            className: 'text-center bg-info text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="quantity_4" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-info text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="price_4" data-index="' +
                                    row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-info text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="dt_4" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        },

                        {
                            data: "id",
                            className: 'text-center bg-secondary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="description_5" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            },
                        }, {
                            data: "id",
                            className: 'text-center bg-secondary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="quantity_5" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-secondary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="price_5" data-index="' +
                                    row.DT_RowIndex + '">'
                            }
                        }, {
                            data: "id",
                            className: 'text-center bg-secondary text-white',
                            render: function(data, type, row) {
                                return '<input type="text" class="form-control" name="dt_5" data-uuid="' +
                                    row.uuid + '" data-index="' + row.DT_RowIndex + '">'
                            }
                        },
                    ],
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next": '<i class="fa fa-angle-right"></i>'
                        }
                    }
                })
                table.on('draw.dt', function() {
                    let totalRows = table.rows().count()

                    console.log(totalRows)

                    for (var rowIndex = 1; rowIndex <= totalRows; rowIndex++) {
                        for (var columnIndex = 1; columnIndex <= 5; columnIndex++) {
                            (function(rowIdx, colIdx) {
                                $('#data_table').on('change',
                                    'input[name="description_' + colIdx +
                                    '"][data-index="' + rowIdx +
                                    '"], input[name="quantity_' + colIdx +
                                    '"][data-index="' + rowIdx +
                                    '"], input[name="price_' + colIdx +
                                    '"][data-index="' + rowIdx +
                                    '"], input[name="dt_' + colIdx +
                                    '"][data-index="' + rowIdx + '"], select[name="supplier_' + colIdx + '"]',
                                    function() {
                                        var row = $(this).closest('tr');
                                        var uuid = row.find('input[name="description_' + colIdx +
                                                '"][data-index="' + rowIdx + '"]')
                                            .data('uuid');
                                        var description = row.find('input[name="description_' + colIdx +
                                                '"][data-index="' + rowIdx + '"]')
                                            .val();
                                        var quantity = row.find('input[name="quantity_' + colIdx +
                                                '"][data-index="' + rowIdx + '"]')
                                            .val();
                                        var price = row.find('input[name="price_' + colIdx +
                                                '"][data-index="' + rowIdx + '"]')
                                            .val();
                                        var dt = row.find('input[name="dt_' + colIdx +
                                                '"][data-index="' + rowIdx + '"]')
                                            .val();
                                        var supplier = $('select[name=supplier_' + colIdx + ']').val();

                                        // console.log(`
                                //     SO: ${$('select[name=so]').val()}
                                //     UUID: ${uuid}
                                //     Description: ${description}
                                //     Quantity: ${quantity}
                                //     Price: ${price}
                                //     DT: ${dt}
                                //     Supplier: ${supplier}
                                //     Row Index: ${rowIdx}
                                //     Column Index: ${colIdx}
                                // `);

                                        if (description != '' && quantity != '' && price != '' && dt != '' &&
                                            supplier !=
                                            null) {

                                            saveReviewProduct($('select[name=so]').val(), uuid, description,
                                                quantity, price,
                                                dt,
                                                supplier)

                                            console.log(`
                                                SO: ${$('select[name=so]').val()}
                                                UUID: ${uuid}
                                                Description: ${description}
                                                Quantity: ${quantity}
                                                Price: ${price}
                                                DT: ${dt}
                                                Supplier: ${supplier}
                                                Row Index: ${rowIdx}
                                                Column Index: ${colIdx}
                                            `);
                                        } else {
                                            console.log('error');
                                        }
                                    });
                            })(rowIndex, columnIndex);
                        }
                    }
                });
            }


            function saveReviewProduct(
                so, uuid, description, quantity, price, dt, supplier
            ) {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.review_save_product') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: so,
                        uuid: uuid,
                        description: description,
                        qty: quantity,
                        price: price,
                        dt: dt,
                        supplier: supplier,
                    },
                    success: function(response) {
                        console.log(response)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
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
                    // reviewurl = '{{ route("transaction.sourcing-item.add", ["id", ":id"]) }}';
                    // reviewurl = reviewurl.replace("id?:id", uuid);
                    // reviewurl = reviewurl + '#btabs-static-review';
                    // $('.review-link').attr("href", reviewurl);
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
                        $('#download-excel').attr('href', '/transaction/sales-order/download/product-list/excel/'+response.uuid)
                        $('#download-pdf').attr('href', '/transaction/sales-order/download/product-list/pdf/'+response.uuid)
                        review_product_select(response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function review_product_select(datas)
            {
                $(datas).each(function(k,v){
                    console.log('product detail', v)
                    no = k + 1;
                    html = `
                        <div class="carl-long-row carl-long-row-`+k+`" data-rowid="`+k+`" data-prodinq="`+v[5]+`">
                            <div class="item-information">
                                <div class="row m-0">
                                    <div class="col-2">
                                        <small>No.</small>
                                        <p>`+ no +`</p>
                                        <input type="hidden" class="product_inquery_id" name="product_inquery_id[]" value="`+v[5]+`">
                                        <input type="hidden" class="so_id" name="so_id[]" value="`+v[6]+`">
                                    </div>
                                    <div class="col-8">
                                        <small>Item Description</small>
                                        <p class="m-0">Item Name : `+ v[0] +`</p>
                                        <p class="m-0">Material Description : `+ v[1] +`</p>
                                        <p class="m-0">Size : `+ v[2] +`</p>
                                        <p class="m-0">Remark : `+ v[4] +`</p>
                                    </div>
                                    <div class="col-2">
                                        <small>Qty</small>
                                        <p>`+v[3]+`</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="supliyer-information-action supliyer-information-action-`+k+`">
                                <a class="btn btn-primary btn-sm text-white" onclick="newform(`+k+`, `+v[5]+`)">
                                    <i class="fa fa-plus"></i> Add More
                                </a>
                            </div>
                        </div>
                    `;

                    $("#product-list").append(html);

                })

                setTimeout(() => {
                        init() 
                    }, 300);
            }

            function listItemTable(status, data)
            {
                if(status == 200) {
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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpload"><i class="fa fa-upload fa-fw"></i> Upload File</button>
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

                            <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modal-slideup" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-slideup" role="document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">Upload File Document</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                        <i class="si si-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <div class="form-group row">
                                                    <label class="col-12">Select Folder</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="select_folder">
                                                            <option value="0" selected disabled>Please select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="upload-file"
                                                                data-toggle="custom-file-input" accept="application/pdf">
                                                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-alt-primary" onclick="upload_files()">
                                                <i class="fa fa-check"></i> Upload Files
                                            </button>
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
                        $('#modalUpload').on('show.bs.modal', function() {
                            console.log(response.data)
                            $('select[name=select_folder]').html('')
                            let element = ''
                            element += `<option selected disabled>Please select</option>`
                            $.each(response.data, function(index, item) {
                                if (item.type == 'folder') {
                                    element += `<option value="${item.name}">${item.name}</option>`
                                }
                            })
                            $('select[name=select_folder]').append(element)
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

            function upload_files() {
                let formData = new FormData()
                formData.append('_token', "{{ csrf_token() }}")
                formData.append('so', $('select[name=so]').val())
                formData.append('folder', $('select[name=select_folder]').val())
                formData.append('file', $('input[name=upload-file]')[0].files[0])

                $.ajax({
                    url: "{{ route('transaction.sourcing-item.upload-file') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response)
                        $('#modalUpload').modal('hide')
                        getStorage($('select[name=so]').val())
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }
        </script>
        <script>
            var SUPLIYER_OPT = {!! json_encode($suppliyers) !!};
            function randomstring(length = 6) {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let randomString = '';

                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * characters.length);
                    randomString += characters.charAt(randomIndex);
                }

                return randomString;
            }

            function calculate_long_row(rowid)
            {
                setTimeout(() => {
                    var currect_long_row = 0;
                    var info_width = $(".item-information").width();
                    var form_width = 450
                    var jumlah_form = 0;
                    $(".supliyer-" + rowid).each(function(k,v){
                        jumlah_form++;
                    }) 
                    $('.carl-long-row').each(function(){
                        if (currect_long_row < $(this).width())  {
                            currect_long_row = $(this).width();
                        }
                    })

                    console.log({
                        "currect_long_row" : currect_long_row,
                        "info_width" : info_width,
                        "form_width" : form_width,
                        "jumlah_form" : jumlah_form
                    })

                    total = info_width + ((form_width + 50 ) * jumlah_form) + 100;
                    if (total > currect_long_row) {
                        $(".carl-long-row").css("width", total + "px");
                    }        
                }, 400);
            }

            function localset(key, val)
            {
                json = JSON.stringify(val);
                console.log("local set " + key + " : ", val);
                window.localStorage.setItem(key, json);
            }

            function localget(key)
            {
                obj = window.localStorage.getItem(key);
                json = JSON.parse(obj);
                console.log("local get " + key + " : ", json);
                return json;
            }

            /* init */
            function init() {
                
                $(".carl-long-row").each(function(){
                    so_id = $(".so_id").val()
                    rowid = $(this).attr("data-rowid");
                    product_inquiry = $(this).attr("data-prodinq");
                    form = localget("form" + so_id);
                    console.log("init", form);
                    if (form) {
                        console.log("form[rowid]", form[rowid]);
                        if (form[rowid]) {
                            for (var key in form[rowid]) {
                                if (form[rowid].hasOwnProperty(key)) {
                                    var obj = form[rowid][key];
                                    console.log("init obj", obj);
                                    newform(rowid, product_inquiry, key, obj);
                                }
                            }
                        }
                    } else {
                        newform(rowid, product_inquiry);
                    } 
                });
            }

            /* add new form */
            function newform(row_id, product_inquiry, rand_id, obj){
                if (!rand_id) {
                    rand_id = randomstring();
                }
                
                var supliyer_options = ``;
                // var selected_supliyer = 
                $(SUPLIYER_OPT).each(function(k,v){
                    if (obj) {
                        if (obj.supliyer_id == v.id) {
                            supliyer_options = supliyer_options + `<option value="`+v.id+`" selected>`+v.company+`</option>`;
                        } else {
                            supliyer_options = supliyer_options + `<option value="`+v.id+`">`+v.company+`</option>`;
                        }
                    } else {
                        supliyer_options = supliyer_options + `<option value="`+v.id+`">`+v.company+`</option>`;
                        obj = {};
                    }

                    console.log("final", obj);
                });
                var html = `
                    <div class="supliyer-information supliyer-`+ rand_id +` supliyer-`+row_id+`">
                        <div class="row m-0">
                            <div class="col-12">
                                
                                <div>
                                    <small>Supliyer</small>
                                    <select name="supplier_id[`+product_inquiry+`][]" class="form-control supliyer-form" data-formid="`+rand_id+`" onchange="supliyer_change(`+row_id+`, $(this))">
                                        <option value="">-Select Suppliyer-</option>
                                        `+supliyer_options+`
                                    </select>
                                </div>
                                <div class="">
                                    <small>Item Description</small>
                                    <textarea name="product_desc[`+product_inquiry+`][]" cols="30" rows="4" placeholder="Product Description" class="form-control" onchange="form_change(`+row_id+`,'product_desc', $(this))" data-formid="`+rand_id+`">`+ (obj.product_desc ?? '') +`</textarea>
                                </div>
                                <div>
                                    <small>Qty</small>
                                    <input type="number" placeholder="Qty" name="product_qty[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_qty', $(this))" data-formid="`+rand_id+`" value="`+ (obj.product_qty ?? '') +`">
                                </div>
                                <div>
                                    <small>Currency</small>
                                    <select name="product_curentcy[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_curentcy', $(this))" data-formid="`+rand_id+`">
                                        <option value="">-Select Curency-</option>
                                        <option value="idr" `+ ((obj.product_curentcy ?? '') == 'idr' ? 'selected' : '') +`>IDR</option>
                                        <option value="usd" `+ ((obj.product_curentcy ?? '') == 'usd' ? 'selected' : '') +`>USD</option>
                                    </select>
                                </div>
                                <div>
                                    <small>{{ '@Price' }}</small>
                                    <input type="number" placeholder="Price" name="product_price[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_price', $(this))" data-formid="`+rand_id+`" value="`+ (obj.product_price ?? '') +`">
                                </div>
                                <div>
                                    <small>Remark</small>
                                    <input type="text" placeholder="Remark" name="remark[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'remark', $(this))" data-formid="`+rand_id+`" value="`+ (obj.remark ?? '') +`">
                                </div>
                                <div>
                                    <small>Production Time</small>
                                    <p>
                                        <input type="text" placeholder="Production Time" name="production_time[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'production_time', $(this))" data-formid="`+rand_id+`" value="`+ (obj.production_time ?? '') +`">
                                    </p>
                                </div>
                                <div class="">
                                    <a class="btn btn-danger btn-sm text-white" onclick="removeform(`+row_id+`, '`+rand_id+`')">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                `;
                $(html).insertBefore(".supliyer-information-action-" + row_id);

                setTimeout(() => {
                    calculate_long_row(row_id);
                }, 200);
            }

            function supliyer_change(rowid, input)
            {
                var so_id = $(".so_id").val()
                var form_id = input.attr("data-formid");
                form = localget("form" + so_id);
                if (!form) {
                    form = {};
                }
                if (!form[rowid]) {
                    form[rowid] = {}
                }
                if (!form[rowid][form_id]) {
                    form[rowid][form_id] = {};
                }
                form[rowid][form_id]["supliyer_id"] = input.val();
                localset("form" + so_id, form);
            }

            function form_change(rowid, formkey, input)
            {
                var so_id = $(".so_id").val()
                var form_id = input.attr("data-formid");
                form = localget("form" + so_id);
                if (!form) {
                    form = {};
                }
                if (!form[rowid]) {
                    form[rowid] = {}
                }
                if (!form[rowid][form_id]) {
                    form[rowid][form_id] = {};
                }
                form[rowid][form_id][formkey] = input.val();
                localset("form" + so_id, form);
            }

            function removeform(rowid, form_id)
            {
                var so_id = $(".so_id").val()
                calculate_long_row(rowid);
                $('.supliyer-' + form_id).remove()

                form = localget("form");
                if (!form) {
                    form = {};
                }
                if (!form[rowid]) {
                    form[rowid] = {}
                }
                if (!form[rowid][form_id]) {
                    form[rowid][form_id] = {};
                }
                
                delete form[rowid][form_id];
                localset("form" + so_id, form);
            }
        </script>
        <style>
            .item-information {
                width:400px;
                min-height: 250px;
                display: inline-block;
            }
        
            .supliyer-information {
                width:400px;
                min-height: 250px;
                display: inline-block;
                background-color: #efefef;
                padding: 10px 5px;
                border-radius: 7px;
                margin-bottom: 5px;
                margin-right: 5px;
            }
        
            .supliyer-information-action {
                width:100px;
                min-height: 250px;
                display: inline-block;
            }

            .carl-long-row {
                min-width: 100%;
            }
        
            small {
                font-weight: bold;
            }
        </style>
    </x-slot>

</x-app-layout>