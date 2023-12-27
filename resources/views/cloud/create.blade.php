<x-app-layout>
    <div class="content">
        <form method="POST" action="{{ route('cloud.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h4><b>Upload Document</b></h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-success mr-5 mb-5 save-customer">
                        <i class="fa fa-save mr-5"></i>Save Document
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
                    <div class="row">
                        <div class="col-md-7">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select name="po_customer" id="pocSelect" class="form-control">
                                                            <option value="0" disabled selected>-- Pilih PO Customer --</option>
                                                            @foreach (App\Models\PurchaseOrderCustomer::all() as $poc)
                                                            <option value="{{ $poc->id }}">{{ $poc->kode_khusus }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Item Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <select name="item_name" id="itemSelect" class="form-control" disabled>
                                                            <option value="0" disabled selected>-- Pilih Item --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Item Description</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control" id="item_description" rows="6px"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Quantity</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" class="form-control" name="" value="" id="item_qty">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row p-5">
                                                <div class="custom-file">
                                                    <input type="hidden" name="document_list" value="">
                                                    <input type="file" id="upload-document" name="upload_document" class="custom-file-input" data-toggle="custom-file-input">
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
            $('#pocSelect').select2();

            let data = [];

            $('#pocSelect').change(function() {
                let pocId = $(this).val();

                $.ajax({
                    url: "{{ route('cloud.getPoc', ':id') }}".replace(':id', pocId)
                    , type: "GET"
                    , success: function(response) {
                        data = response.data;
                        dataDisplay(data);
                    }
                    , error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            function dataDisplay(data) {
                $('#itemSelect').empty();
                $('#itemSelect').append('<option selected disabled>-- Pilih Item --</option>');

                data.forEach(function(item, index) {
                    $('#itemSelect').attr('disabled', false);
                    $('#itemSelect').append($('<option>', {
                        value: item.uuid
                        , text: item.item_name
                    }));
                });

                $('#itemSelect').select2();
            }

            $('#itemSelect').change(function() {
                let selectedItemUuid = $(this).val();
                let selectedItem = data.find(item => item.uuid === selectedItemUuid);
                updateItemDescription(selectedItem);
            });

            function updateItemDescription(item) {
                let descriptionHtml = item.item_name + `\n` + item.description + `\n` + item.size + `\n` + item.remark;
                $('#item_description').html(descriptionHtml);
                $('#item_qty').val(item.qty);
            }

            const handleListDocument = (data) => {
                var element = ``;
                var iteration = 1;
                $.each(data, function(index, value) {
                    element += `
                        <li class="list-group-item" data-id="${value.filename}">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/files/cloud-storage/${value.filename}" target="_blank">${iteration + '. ' + value.aliases}</a>
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
                    url: `{{ route('cloud.upload-document') }}`
                    , type: 'POST'
                    , data: formData
                    , processData: false
                    , contentType: false
                    , success: function(res) {
                        $('#upload-document-loading').removeClass('d-flex');
                        $('#upload-document-loading').addClass('d-none');

                        if (res.status === 200) {
                            handleListDocument(res.data);
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                await $(`#upload-document-label`).html('Choose file');
            }

            $(document).on('change', `input[name=upload_document]`, function() {
                $(`#upload-document-loading`).removeClass('d-none');
                $(`#upload-document-loading`).addClass('d-flex');

                handleUploadDocument($(this).prop('files')[0]);
            });

            $(document).on('click', `[remove_document]`, function() {
                const thisList = $(this).closest('li');
                $.ajax({
                    url: "{{ route('cloud.upload-document') }}"
                    , type: "POST"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , method: 'DELETE'
                        , file_name: thisList.data('id')
                        , other_files: $(`input[name="document_list"]`).val()
                    , }
                    , success: function(res) {
                        if (res.status === 200) {
                            handleListDocument(res.data);
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

        </script>
    </x-slot>
</x-app-layout>
