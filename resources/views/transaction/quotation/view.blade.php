<x-app-layout>
    @if (auth()->user()->hasRole('sales'))
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>SO NUMBER : {{ $query->sales_order->id }}</b></h4>
            </div>
            <div class="col-md-6 text-right">
                @if ($query->status === 'Waiting for Approval')
                <form method="post" action="{{ route('transaction.quotation.view', $query->id) }}">
                    @method('patch')
                    @csrf

                    <input type="hidden" name="status" value="approve">

                    <button type="submit" class="btn btn-primary mr-5 mb-5">
                        <i class="fa fa-check mr-5"></i>
                        Approval
                    </button>

                    <button type="button" class="btn btn-danger mr-5 mb-5" data-toggle="modal" data-target="#modal-reject">
                        <i class="fa fa-ban mr-5"></i>
                        Rejected
                    </button>
                </form>
                @else
                <a href="{{ route('transaction.quotation') }}" class="btn btn-danger mr-5 mb-5">
                    <i class="fa fa-arrow-circle-o-left mr-2"></i>Back
                </a>
                <button type="button" class="btn btn-primary mr-5 mb-5" data-toggle="modal" data-target="#modal-revision">
                    <i class="fa fa-refresh mr-2"></i>
                    Revision
                </button>
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
                            <a class="nav-link" href="#btabs-static-review">Term &amp; Condition</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#btabs-static-doc">Document</a>
                        </li>
                        @if($query->revision_note !== null)
                        <li class="nav-item">
                            <a class="nav-link" href="#btabs-static-revision">Revision Note</a>
                        </li>
                        @endif
                    </ul>

                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12">
                                    @include('transaction.quotation.partials.print_body')
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last-name-column">Quotation Valid Until</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->due_date }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Delivery Term</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->delivery_term }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Validity</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->validity }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Term</label>
                                                <input type="text" class="form-control" name="" value="{{ $paymentTerms[$query->payment_term] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>PPN</label>
                                                <input type="text" class="form-control" name="" value="{{ $vatTypes[$query->vat] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Attachment</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->attachment }}" readonly>
                                            </div>
                                        </div>

                                        @if ($query->status === 'Rejected')
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Rejecting Reason</label>
                                                <textarea class="form-control" disabled rows="5">{{ $query->reason_for_refusing }}</textarea>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                        </div>
                                        <div class="block block-rounded mt-3">
                                            <div class="block-content block-content-full bg-pattern">
                                                <h5>Document List</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="product-file-type">
                                                <ul class="list-unstyled" id="document-attachment-list">

                                                </ul>
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

    <div class="modal fade" id="modal-revision" tabindex="-1" role="dialog" aria-labelledby="modal-revision" aria-hidden="true">
        <form method="post" action="{{ route('transaction.quotation.revision-comment', $query->id) }}">
            @method('patch')
            @csrf

            <input type="hidden" name="status" value="revision">

            <div class="modal-dialog modal-dialog-revision" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Revision</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group">
                                <label>Revision Note</label>
                                <textarea class="form-control" name="revision_note" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-check"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modal-reject" aria-hidden="true">
        <form method="post" action="{{ route('transaction.quotation.view', $query->id) }}">
            @method('patch')
            @csrf

            <input type="hidden" name="status" value="reject">

            <div class="modal-dialog modal-dialog-reject" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Rejected</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason_for_refusing" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" onclick="searchCustomer()" class="btn btn-alt-primary">
                            <i class="fa fa-check"></i>
                            Sent
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @else
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>Quotation Number : {{ $query->quotation_code }}</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('transaction.quotation') }}" class="btn btn-danger mr-5 mb-5">
                    <i class="fa fa-arrow-circle-o-left mr-2"></i>Back
                </a>
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
                            <a class="nav-link" href="#btabs-static-review">Term &amp; Condition</a>
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
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->id }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Sales
                                                            Name</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->sales->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Customer &
                                                            Company
                                                            Name</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->visit->customer->name }}" readonly>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->visit->customer->company }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Phonne &
                                                            Email</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->visit->customer->phone }}" readonly>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->visit->customer->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Telp</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->visit->customer->company_phone }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Subject</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->subject }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Due Date</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->due_date }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Grade</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="" value="{{ $query->sales_order->inquiry->grade }} %" readonly>
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
                                            {{-- <h5>Document List</h5>
                                                @if ($query->sales_order->inquiry->files)
                                                    <?php
                                                    $files = json_decode($query->sales_order->inquiry->files);
                                                    if ($files) {
                                                    $fileName = $files[0]->filename;
                                                    ?>
                                                    <a href="{{ url('') }}/file/show/inquiry/{{ $query->sales_order->inquiry->visit->uuid }}/{{ $fileName }}"
                                            target="_blank" file="">
                                            <i class="fa fa-eye"></i>
                                            Show File
                                            </a>
                                            <?php
                                                    }
                                                    ?>
                                            @endif --}}
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
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-vcenter table-bordered w-100 js-dataTable-simple" style="font-size:13px" list_products>
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 2%;">No.</th>
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">Material Desc</th>
                                                    <th class="text-center">Size</th>
                                                    <th class="text-center" style="width: 10%;">QTY</th>
                                                    <th class="text-center" style="width: 10%;">Remark</th>
                                                    <th class="text-center" style="width: 10%;">Delivery Time</th>
                                                    <th class="text-center" style="width: 8%;">Unit Price</th>
                                                    <th class="text-center" style="width: 12%;">UP Price</th>
                                                    <th class="text-center" style="width: 12%;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($query->quotation_items as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->inquiry_product->item_name }}</td>
                                                    <td>{{ $item->inquiry_product->description }}</td>
                                                    <td>{{ $item->inquiry_product->size }}</td>
                                                    <td class="text-right">
                                                        {{ $item->inquiry_product->sourcing_qty }}
                                                    </td>
                                                    <td>
                                                        {{ $item->inquiry_product->remark }}
                                                    </td>
                                                    <td>{{ $item->inquiry_product->delivery_time }}</td>
                                                    <td class="text-right text-nowrap">
                                                        Rp
                                                        {{ number_format($item->inquiry_product->cost, 2, ',', '.') }}
                                                    </td>
                                                    <td class="text-right text-nowrap">
                                                        Rp {{ number_format($item->cost, 2, ',', '.') }}
                                                    </td>
                                                    <td class="text-right text-nowrap">
                                                        Rp {{ number_format($item->total_cost, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
                                            <div>{!! $query->sales_order->inquiry->description !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last-name-column">Quotation Valid Until</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->due_date }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Delivery Term</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->delivery_term }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Validity</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->validity }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Term</label>
                                                <input type="text" class="form-control" name="" value="{{ $paymentTerms[$query->payment_term] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>PPN</label>
                                                <input type="text" class="form-control" name="" value="{{ $vatTypes[$query->vat] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Documents</label>
                                                <input type="text" class="form-control" name="" value="{{ $query->attachment }}" readonly>
                                            </div>
                                        </div>

                                        @if ($query->status === 'Rejected')
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Rejecting Reason</label>
                                                <textarea class="form-control" disabled rows="5">{{ $query->reason_for_refusing }}</textarea>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                        </div>
                                        <div class="block block-rounded mt-3">
                                            <div class="block-content block-content-full bg-pattern">
                                                <h5>Document List</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="product-file-type">
                                                <ul class="list-unstyled" id="document-attachment-list">

                                                </ul>
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
    @endif
</x-app-layout>
<style>
    .block-file-header {
        background-color: #eee;
        width: 50px;
        height: 50px;
        padding: 10px;
    }

    .block-file-body {
        padding-top: 15px;
    }

</style>
<script>
    /* upload and show document start */

    /* triggers */

    $(document).ready(function() {
        SOID = '{{ $id }}';
        getDocuments();
    })

    $("#example-file-input-custom").change(function() {
        var fileinfo = $(this)[0].files[0];
        addDocument(fileinfo);
    });

    /* functions */

    function addDocument(fileinfo) {
        var formData = new FormData();

        formData.append('file', fileinfo);
        formData.append('related_table', 'quotations');
        formData.append('related_id', SOID);
        formData.append('file_size', fileinfo.size);
        formData.append('file_type', fileinfo.type);
        formData.append('_token', "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('helper.docadd') }}"
            , type: 'POST'
            , data: formData
            , processData: false
            , contentType: false
            , success: function(data, status) {
                if (status == "success") {
                    getDocuments()
                }
            }
            , error: function(data, status) {
                alert("Upload gagal, pastikan file yang diupload tidak terlalu besar dan tidak corrupt!");
            }
        });
    }

    function getDocuments() {
        $.get("{{ route('helper.doclist') }}?related_table=quotations&related_id=" + SOID, function(res) {

            baseurl = "{{ asset('storage') }}/";
            htmlDocuments = ``
            $.each(res.data, function(k, v) {

                filetype = "";
                sliptstr = v.file_type.split("/");
                filetype = sliptstr[1];

                htmlDocuments = htmlDocuments +
                    `
                <li class="media media-list">
                    <span class="mr-3 align-self-center img-icon primary-rgba text-primary d-block block-file-header">.` +
                    filetype + `</span>
                    <div class="media-body block-file-body">
                        <h5 class="font-16 mb-1">` + v.filename + `
                            <span class="float-right">
                            <a href="` + baseurl + v.path + `" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                            <a onclick="rmDocument(` + v.id + `)" class="btn btn-sm btn-danger delete-pointer"><i class="fa fa-trash text-white"></i></a>
                            <span>
                        </h5>
                        <p>` + v.timeago + `, ` + (v.file_size / 1024).toFixed(2) + ` KB</p>
                    </div>
                </li>
                `;
            })
            getOtherDocuments();
            setTimeout(() => {
                $("#document-attachment-list").html(htmlDocuments);
            }, 200);
        });
    }

    function getOtherDocuments(htmlDocuments) {
        $.get("{{ route('helper.doclistother') }}?related_table=quotations&related_id=" + SOID, function(res) {
            inquiry_id = `<h5 class="mt-4">Inquiry : ${res.data.inquiry.id}</h5>`;
            sales_id = `<h5 class="mt-4">Sales Order : ${res.data.sales_orders.id}</h5>`;
            sourcing_id = `<h5 class="mt-4">Sourcing Item : ${res.data.sourcings.id}</h5>`;

            baseurl = "{{ asset('storage') }}/";
            html = ``

            file_inquiry = inquiry_id;
            $.each(res.data.inquiry.files, function(k, v) {
                file_inquiry = file_inquiry +
                    `
                        <li class="media media-list">
                                <span class="mr-3 align-self-center img-icon primary-rgba text-primary d-block block-file-header">.pdf</span>
                                <div class="media-body block-file-body">
                                    <h5 class="font-16 mb-1">` + v.aliases + `
                                        <span class="float-right">
                                        <a href="` + v.url + `" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                        <span>
                                    </h5>
                                </div>
                        </li>
                    `
            })

            file_sales = sales_id;
            $.each(res.data.sales_orders.files, function(k, v) {
                file_sales = file_sales +
                    `
                        <li class="media media-list">
                                <span class="mr-3 align-self-center img-icon primary-rgba text-primary d-block block-file-header">.pdf</span>
                                <div class="media-body block-file-body">
                                    <h5 class="font-16 mb-1">` + v.aliases + `
                                        <span class="float-right">
                                        <a href="` + v.url + `" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                        <span>
                                    </h5>
                                </div>
                        </li>
                    `
            })

            file_sourcing = sourcing_id;
            $.each(res.data.sourcings.files, function(k, v) {
                filetype = "";
                sliptstr = v.file_type.split("/");
                filetype = sliptstr[1];

                file_sourcing = file_sourcing +
                    `
                        <li class="media media-list">
                            <span class="mr-3 align-self-center img-icon primary-rgba text-primary d-block block-file-header">.` +
                    filetype + `</span>
                            <div class="media-body block-file-body">
                                <h5 class="font-16 mb-1">` + v.filename + `
                                    <span class="float-right">
                                    <a href="` + baseurl + v.path + `" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                </h5>
                                <p>` + v.timeago + `, ` + (v.file_size / 1024).toFixed(2) + ` KB</p>
                            </div>
                        </li>
                    `;
            })
            html = file_inquiry + file_sales + file_sourcing;
            setTimeout(() => {
                $('#document-attachment-list').html(htmlDocuments)
                $("#document-attachment-list").append(html);
            }, 200);
        });
    }

    function rmDocument(id) {
        response = window.confirm("Apa anda yakin ingin menghapus document ini? Aksi ini tidak bisa di-rollback")
        if (response) {
            $.post("{{ route('helper.docrem') }}", {
                _token: "{{ csrf_token() }}"
                , id: id
            }, function(data) {
                getDocuments()
            })
        } else {
            return false;
        }
    }

    /* upload and show document finish */

</script>
