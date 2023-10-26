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

                            <button type="button" class="btn btn-danger mr-5 mb-5" data-toggle="modal"
                                data-target="#modal-reject">
                                <i class="fa fa-ban mr-5"></i>
                                Rejected
                            </button>
                        </form>
                    @else
                        <a href="{{ route('transaction.quotation') }}" class="btn btn-danger mr-5 mb-5">
                            <i class="fa fa-arrow-circle-o-left mr-2"></i>Back
                        </a>
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
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->due_date }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Delivery Term</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->delivery_term }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Validity</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->validity }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Payment Term</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $paymentTerms[$query->payment_term] }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>PPN</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $vatTypes[$query->vat] }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Attachment</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->attachment }}" readonly>
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
                        </div>
                    </div>
                </div>
            </div>
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
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->id }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Sales
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->sales->name }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Customer &
                                                                Company
                                                                Name</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->name }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->company }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Phonne &
                                                                Email</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->phone }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->email }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Telp</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->visit->customer->company_phone }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Subject</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->subject }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Due Date</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->due_date }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Grade</label>
                                                            <label class="col-lg-1 col-form-label text-right">:</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    name=""
                                                                    value="{{ $query->sales_order->inquiry->grade }} %"
                                                                    readonly>
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
                                                @if ($query->sales_order->inquiry->files)
                                                    <?php
                                                    $files = json_decode($query->sales_order->inquiry->files);
                                                    $fileName = $files[0]->filename;
                                                    ?>
                                                    <a href="{{ url('') }}/file/show/inquiry/{{ $query->sales_order->inquiry->visit->uuid }}/{{ $fileName }}"
                                                        target="_blank" file="">
                                                        <i class="fa fa-eye"></i>
                                                        Show File
                                                    </a>
                                                @endif
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
                                        <table class="table table-bordered table-vcenter js-dataTable-simple"
                                            style="font-size:13px">
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
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->due_date }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Delivery Term</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->delivery_term }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="last-name-column">Validity</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->validity }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Payment Term</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $paymentTerms[$query->payment_term] }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>PPN</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $vatTypes[$query->vat] }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Attachment</label>
                                                    <input type="text" class="form-control" name=""
                                                        value="{{ $query->attachment }}" readonly>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modal-reject"
            aria-hidden="true">
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
                                    <button type="button" class="btn-block-option" data-dismiss="modal"
                                        aria-label="Close">
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
    @endif
</x-app-layout>
