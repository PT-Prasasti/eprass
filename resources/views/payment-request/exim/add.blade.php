<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('payment-request.exim.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>{{ $transactionCode }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-primary mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Data
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
                                <a class="nav-link" href="#bank">Bank Information</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <input type="hidden" name="payment_code" value="">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Subject
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="subject" required>
                                                            <option disabled selected hidden>- PILIH SUBJECT -</option>
                                                            <option value="PEMBELIAN">PEMBELIAN</option>
                                                            <option value="REIMBURSE">REIMBURSE</option>
                                                            <option value="EXPENSES">EXPENSES</option>
                                                            <option value="LAPORAN KEUANGAN">LAPORAN KEUANGAN</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Submission Date
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="submission_date" value="{{ now()->format('d F Y') }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Position
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="position" value="{{ ucfirst(auth()->user()->roles()->first()->name) }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p>List Payment Request :</p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-success mr-5 mb-5" id="buttonAddPR" data-toggle="modal" data-target="#modal-add" disabled>
                                            <i class="fa fa-plus mr-5"></i>Add Data
                                        </button>
                                    </div>

                                    <div class="col-md-12 table-responsive" id="viewTable">
                                        <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Remark</th>
                                                    <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Modal Add PR --}}
                                <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-popin modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Add Data Payment Request</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Date <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="date" class="form-control" id="date">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Item <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <select class="form-control" id="subject">
                                                                    <option value="0">- SELECT ITEM -</option>
                                                                    <option value="TRANSPORT">TRANSPORT</option>
                                                                    <option value="TOLL">TOLL</option>
                                                                    <option value="FUEL">FUEL</option>
                                                                    <option value="PARKING FEE">PARKING FEE</option>
                                                                    <option value="FLIGHT TICKET">FLIGHT TICKET</option>
                                                                    <option value="HOTEL">HOTEL</option>
                                                                    <option value="VISA">VISA</option>
                                                                    <option value="TELEPHONE">TELEPHONE</option>
                                                                    <option value="OTHERS">OTHERS</option>
                                                                    <option value="ALLOWANCE">ALLOWANCE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Description <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <textarea class="form-control" id="description" rows="3" placeholder="Description"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Amount <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control" id="amount" placeholder="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Remark <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control" id="remark" placeholder="Remark">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">File</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="file" class="form-control" id="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-5">
                                                <button type="submit" class="btn btn-primary" data-dismiss="modal" id="addItemButton">
                                                    <i class="fa fa-save"></i> SAVE DATA
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Add PR --}}

                                {{-- Modal Edit PR --}}
                                <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-popin modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Edit Data Payment Request</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Date <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="date" class="form-control" id="dateEdit">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Item <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <select class="form-control" required id="itemEdit">
                                                                    <option value="0">- SELECT ITEM -</option>
                                                                    <option value="TRANSPORT">TRANSPORT</option>
                                                                    <option value="TOLL">TOLL</option>
                                                                    <option value="FUEL">FUEL</option>
                                                                    <option value="PARKING FEE">PARKING FEE</option>
                                                                    <option value="FLIGHT TICKET">FLIGHT TICKET</option>
                                                                    <option value="HOTEL">HOTEL</option>
                                                                    <option value="VISA">VISA</option>
                                                                    <option value="TELEPHONE">TELEPHONE</option>
                                                                    <option value="OTHERS">OTHERS</option>
                                                                    <option value="ALLOWANCE">ALLOWANCE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Description <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <textarea class="form-control" rows="3" placeholder="Description" id="descriptionEdit"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Amount <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control" placeholder="0" id="amountEdit">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Remark <span class="text-danger">*</span></label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control" placeholder="Remark" id="remarkEdit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-5">
                                                <button type="button" class="btn btn-primary" id="editItemButton" data-dismiss="modal">
                                                    <i class="fa fa-save"></i> SAVE DATA
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Edit PR --}}
                            </div>


                            <div class="tab-pane" id="bank" role="tabpanel">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Name</label>
                                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Swift / Code</label>
                                                    <input type="text" class="form-control @error('bank_swift') is-invalid @enderror" name="bank_swift" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Account</label>
                                                    <input type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Number</label>
                                                    <input type="text" class="form-control @error('bank_number') is-invalid @enderror" name="bank_number" required>
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
            let totalAmount = 0;
            var paymentCode;
            $(document).ready(function() {
                generateId();
                buttonAddPr();
            });

            function generateId() {
                var url = "{{ route('payment-request.exim.id') }}"
                $.get(url, function(response) {
                    paymentCode = response;
                    $('input[name=payment_code]').val(response)
                })
                getProductList(paymentCode);
            }

            function getProductList(paymentCode) {
                $('#viewTable').html(``);
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th>Date</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Remark</th>
                                                    <th>File</th>
                                                    <th><i class="fa fa-ellipsis-h"></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="4"><span class="fw-bold"><strong>TOTAL :</strong></span></td>
                                                    <td class="text-left" colspan="3"><span id="total-amount" class="fw-bold">0.00</span></td>
                                                </tr>
                                            </tfoot>
                                        </table>`);
                $('#dataTable').DataTable({
                    processing: true
                    , serverSide: true
                    , responsive: true
                    , "paging": true
                    , "order": [
                        [1, "desc"]
                    ]
                    , ajax: {
                        "url": "{{ route('payment-request.exim.get_product') }}"
                        , "type": "POST"
                        , "data": {
                            "_token": "{{ csrf_token() }}"
                            , "paymentCode": paymentCode
                        }
                    , }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                            , width: "8%"
                            , className: "text-center"
                        }
                        , {
                            data: "date"
                        }
                        , {
                            data: "item"
                        }
                        , {
                            data: "description"
                        }
                        , {
                            data: "amount"
                        }
                        , {
                            data: "remark"
                        }
                        , {
                            data: "file"
                            , render: function(data, type, full, meta) {
                                let userId = "{{ auth()->user()->uuid }}";
                                if (data) {
                                    // Extract the iteration from the Redis key
                                    let parts = full.redis_key.split('_');
                                    let iteration = parts.pop(); // Get the last part of the key

                                    return `<a href="show/${userId}/${iteration}/${data.filename}" target="_blank">${data.aliases}</a>`;
                                } else {
                                    return '';
                                }
                            }
                        }
                        , {
                            // Kolom untuk tombol atau tindakan lainnya
                            data: "redis_key"
                            , className: "text-center"
                            , render: function(data, type, full, meta) {
                                // Tambahkan tombol atau tindakan di sini
                                return `<button type="button" class="btn btn-warning" onclick="getEditItem('${data}')" data-toggle="modal" data-target="#modal-edit">
                                            <i class="fa fa-pencil "></i>
                                        </button>
                                        <button type="button" onclick="deleteData('${data}')" class="btn btn-danger" data-toggle="tooltip" title="Delete Item">
                                            <i class="fa fa-trash"></i>
                                        </button>`;
                            }
                        }
                    , ]
                    , "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>'
                            , "next": '<i class="fa fa-angle-right"></i>'
                        }
                    },
                    "footerCallback": function(row, data, start, end, display) {
                            let api = this.api();

                            // Hitung total amount
                            let totalAmount = api
                                .column(4, {
                                    search: 'applied'
                                })
                                .data()
                                .reduce(function(acc, val) {
                                    // Hilangkan karakter 'Rp' dan spasi, serta titik (.) sebagai pemisah ribuan
                                    let numericVal = parseFloat(val.replace(/[^0-9]/g, ''));
                                    // Periksa apakah nilai numerikVal adalah angka valid
                                    if (!isNaN(numericVal)) {
                                        return acc + numericVal;
                                    } else {
                                        return acc; // Kembalikan nilai sebelumnya jika tidak valid
                                    }
                                }, 0);

                            // Update nilai total-amount
                            let formattedAmount = handleCurrencyFormat(totalAmount);
                            $('#total-amount').html('<strong>' + formattedAmount + '</strong>');
                        }

                , });
            }

            const handleCurrencyFormat = (value) => {
                return value.toLocaleString('id-ID', {
                    style: 'currency'
                    , currency: 'IDR'
                    , maximumFractionDigits: 2
                , });
            }

            function buttonAddPr() {
                $('select[name=subject]').on('change', function() {
                    const selectedSubject = $(this).find('option:selected').val();

                    if (selectedSubject && selectedSubject !== '- PILIH SUBJECT -') {
                        $('#buttonAddPR').prop('disabled', false);
                    } else {
                        $('#buttonAddPR').prop('disabled', true);
                    }
                });
            }

            $('#addItemButton').click(function(e) {
                e.preventDefault();
                const modalData = getModalData();
                // file upload
                const file = $('#file').prop('files')[0];
                storeProduct(modalData, file);
            });

            $('#editItemButton').click(function(e) {
                itemKey = $(this).data('key');
                e.preventDefault();
                const modalData = getModalDataUpdate();
                updateProduct(modalData, itemKey);
            });

            function storeProduct(data, file) {
                const paymentCode = $('input[name=payment_code]').val();

                // Create a FormData object
                const formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('payment_code', paymentCode);
                formData.append('file', file);

                // Append each data item to the FormData
                for (const key in data) {
                    formData.append(`data[${key}]`, data[key]);
                }

                $.ajax({
                    url: "{{ route('payment-request.exim.store_product') }}"
                    , type: "POST"
                    , data: formData
                    , processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(response) {
                        $('input[id=date]').val('');
                        $('input[id=item]').val('');
                        $('textarea[id=description]').val('');
                        $('input[id=amount]').val('');
                        $('input[id=remark]').val('');
                        getProductList(paymentCode);
                    }
                    , error: function(xhr, status, error) {
                        console.error(error)
                    }
                });
            }

            function updateProduct(data, itemKey) {
                const paymentCode = $('input[name=payment_code]').val();

                $.ajax({
                    url: "{{ route('payment-request.exim.update_product') }}"
                    , type: "POST"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , redis_key: itemKey
                        , data: data
                    }
                    , success: function(response) {
                        getProductList(paymentCode);
                    }
                    , error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function getModalData() {
                // Validate required fields before proceeding
                const requiredFields = ['date', 'subject', 'description', 'amount', 'remark'];
                const missingFields = requiredFields.filter(field => !$('#' + field).val().trim());

                if (missingFields.length > 0) {
                    Swal.fire({
                        title: 'Error!'
                        , text: `Please fill in the following required fields: ${missingFields.join(', ')}`
                        , icon: 'error'
                    });
                    return null;
                }

                const amountValue = parseFloat($('#amount').val().replace(/[^,\d]/g, ''));

                return {
                    date: $('#date').val()
                    , item: $('#subject').val()
                    , description: $('#description').val()
                    , amount: amountValue
                    , remark: $('#remark').val()
                };
            }

            function getModalDataUpdate() {
                // Validate required fields before proceeding
                const requiredFields = ['dateEdit', 'itemEdit', 'descriptionEdit', 'amountEdit', 'remarkEdit'];
                const missingFields = requiredFields.filter(field => !$('#' + field).val().trim());

                if (missingFields.length > 0) {
                    Swal.fire({
                        title: 'Error!'
                        , text: `Please fill in the following required fields: ${missingFields.join(', ')}`
                        , icon: 'error'
                    });
                    return null;
                }

                const amountValue = parseFloat($('#amountEdit').val().replace(/[^,\d]/g, ''));

                return {
                    date: $('#dateEdit').val()
                    , item: $('#itemEdit').val()
                    , description: $('#descriptionEdit').val()
                    , amount: amountValue
                    , remark: $('#remarkEdit').val()
                , };
            }

            function getEditItem(id) {
                $.ajax({
                    url: "{{ route('payment-request.exim.get_edit_data') }}"
                    , type: "POST"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , redis_key: id
                    }
                    , success: function(response) {
                        let amount = handleRupiahFormat(handleSetNumber(response.data.amount));
                        $('input[id=dateEdit]').val(response.data.date);
                        $('select[id=itemEdit]').val(response.data.item);
                        $('textarea[id=descriptionEdit]').val(response.data.description);
                        $('input[id=amountEdit]').val(amount);
                        $('input[id=remarkEdit]').val(response.data.remark);
                        $('#editItemButton').attr('data-key', response.key)
                    }
                })
            }

            function deleteData(id) {
                Swal.fire({
                    title: 'Are you sure?'
                    , text: "You won't be able to revert this!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('payment-request.exim.delete_data') }}"
                            , type: "POST"
                            , data: {
                                _token: "{{ csrf_token() }}"
                                , redis_key: id
                            }
                            , success: function(response) {
                                console.log(response);
                                getProductList($('input[name=payment_code]').val());

                            }
                            , error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                })
            }


            function handleRupiahFormat(number, prefix) {
                let numberToString = number.toString().replace(/[^,\d]/g, '')
                    , split = numberToString.split(',')
                    , sisa = split[0].length % 3
                    , rupiah = split[0].substr(0, sisa)
                    , ribuan = split[0].substr(sisa).match(/\d{3}/gi);

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

            $(document).on("input", "#amount", function() {
                this.value = handleRupiahFormat(handleSetNumber(this.value));
            });

            $(document).on("input", "#amountEdit", function() {
                this.value = handleRupiahFormat(handleSetNumber(this.value));
            });

        </script>
    </x-slot>
</x-app-layout>
