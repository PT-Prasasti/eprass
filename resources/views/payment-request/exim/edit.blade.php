<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('payment-request.exim.update', $query->uuid) }}">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-md-6">
                    <h4><b>{{ $query->id }}</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    @if(auth()->user()->hasRole('exim'))
                    <button type="submit" class="btn btn-primary mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Data
                    </button>
                    @else
                        @if (!Str::startsWith($query->status, 'Rejected by '))
                            <button type="submit" class="btn btn-primary mr-5 mb-5">
                            <i class="fa fa-check mr-5"></i>Approved
                            </button>
                            <button type="button" class="btn btn-danger mr-5 mb-5" data-toggle="modal" data-target="#modalRejected">
                            <i class="fa fa-close mr-5"></i>Rejected
                            </button>
                        @endif
                    @endif
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
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">
                                                        Subject
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="subject" required {{ auth()->user()->hasRole('exim') ? '' : 'readonly' }}>
                                                            <option disabled selected hidden>- PILIH SUBJECT -</option>
                                                            <option value="PEMBELIAN" {{ $query->subject == 'PEMBELIAN' ? 'selected' : '' }}>PEMBELIAN</option>
                                                            <option value="REIMBURSE" {{ $query->subject == 'REIMBURSE' ? 'selected' : '' }}>REIMBURSE</option>
                                                            <option value="EXPENSES" {{ $query->subject == 'EXPENSES' ? 'selected' : '' }}>EXPENSES</option>
                                                            <option value="LAPORAN KEUANGAN" {{ $query->subject == 'LAPORAN KEUANGAN' ? 'selected' : '' }}>LAPORAN KEUANGAN</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Submission Date
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="submission_date" value="{{ $query->submission_date }}" readonly>
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
                                                        <input type="text" class="form-control" name="name" value="{{ $query->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Position
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="position" value="{{ $query->position }}" readonly>
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
                                                    <th class="text-center">File</th>
                                                    @if(auth()->user()->hasRole('exim'))
                                                    <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($query->payment_request_item as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->date)->format('d F Y') }}</td>
                                                    <td class="text-center">{{ $item->item }}</td>
                                                    <td class="text-center">{{ $item->description }}</td>
                                                    <td class="text-center">{{ number_format($item->amount, 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ $item->remark }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ asset('storage' . '/' . $item->file_document) }}" target="_blank">
                                                            {{ $item->file_aliases }}
                                                        </a>
                                                    </td>
                                                    @if(auth()->user()->hasRole('exim'))
                                                        <td class="text-center"><button type="button" class="btn btn-warning" onclick="getEditItem('{{ $item->uuid }}')" data-toggle="modal" data-target="#modal-edit">
                                                                <i class="fa fa-pencil "></i>
                                                            </button>
                                                            <button type="button" onclick="deleteData('${data}')" class="btn btn-danger" data-toggle="tooltip" title="Delete Item">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
                                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $query->bank_name }}" required {{ auth()->user()->hasRole('exim') ? '' : 'readonly' }}>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Swift / Code</label>
                                                    <input type="text" class="form-control @error('bank_swift') is-invalid @enderror" name="bank_swift" value="{{ $query->bank_swift }}" required {{ auth()->user()->hasRole('exim') ? '' : 'readonly' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Account</label>
                                                    <input type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" value="{{ $query->bank_account }}" required {{ auth()->user()->hasRole('exim') ? '' : 'readonly' }}>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Bank Number</label>
                                                    <input type="text" class="form-control @error('bank_number') is-invalid @enderror" name="bank_number" value="{{ $query->bank_number }}" required {{ auth()->user()->hasRole('exim') ? '' : 'readonly' }}>
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

            {{-- Modal Rejected --}}
            <div class="modal fade" id="modalRejected" tabindex="-1" role="dialog" aria-labelledby="modalRejected" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Note</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                            <textarea class="form-control" id="rejected_note" name="rejected_note" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-alt-secondary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-alt-success">
                                <i class="fa fa-check"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modal Rejected --}}
        </form>
    </div>

    <x-slot name="js">
        <script>
            var paymentCode;
            $(document).ready(function() {
                $("#editItemButton").click(function() {
                    updateItem();
                })
            })
            const handleCurrencyFormat = (value) => {
                return value.toLocaleString('id-ID', {
                    style: 'currency'
                    , currency: 'IDR'
                    , maximumFractionDigits: 2
                , });
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

            function getEditItem(id) {
                $.ajax({
                    url: "{{ route('payment-request.exim.get-edit-data') }}"
                    , type: "POST"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , id: id
                    }
                    , success: function(response) {
                        let amount = handleRupiahFormat(handleSetNumber(response.data.amount));
                        $('input[id=dateEdit]').val(response.data.date);
                        $('select[id=itemEdit]').val(response.data.item);
                        $('textarea[id=descriptionEdit]').val(response.data.description);
                        $('input[id=amountEdit]').val(amount);
                        $('input[id=remarkEdit]').val(response.data.remark);
                        $('#editItemButton').attr('data-id', response.data.id)
                    }
                })
            }

            function updateItem() {
                let date = $('input[id=dateEdit]').val();
                let item = $('select[id=itemEdit]').val();
                let description = $('textarea[id=descriptionEdit]').val();
                let amount = $('input[id=amountEdit]').val();
                let remark = $('input[id=remarkEdit]').val();
                let id = $('#editItemButton').attr('data-id')

                $.ajax({
                    url: '{{ route('payment-request.exim.update_product_2') }}',
                    type: "POST", 
                    data: {
                        _token: "{{ csrf_token() }}",
                        date: date
                        , item: item
                        , description: description
                        , amount: amount
                        , remark: remark,
                        id: id
                    }, 
                    success: function(response) {
                        window.location.reload();
                    }, 
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
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
