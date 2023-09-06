<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>ID Inquiry : <span>{{ $inquiry->id }}</span></b></h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('crm.inquiry') }}" class="btn btn-danger mr-5 mb-5">
                    <i class="fa fa-arrow-circle-o-left mr-2"></i>Back
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-content block-content-full bg-pattern">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Sales Name</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ ucwords($inquiry->sales->name) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Customer & Company Name</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" value="{{ ucwords($inquiry->visit->customer->name) }}" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" value="{{ ucwords($inquiry->visit->customer->company) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Phone & Email</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" value="{{ $inquiry->visit->customer->phone }}" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" value="{{ $inquiry->visit->customer->email }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Telp</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ $inquiry->visit->customer->company_phone }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subject</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ $inquiry->subject }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Due Date</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ Carbon\Carbon::parse($inquiry->due_date)->format('d M Y') }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Grade</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ $inquiry->grade }}%" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">SO Number</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{{ isset($inquiry->sales_order) ? $inquiry->sales_order->id : '' }}" readonly>
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
                        @php
                            $no = 1;
                        @endphp
                        @if(json_decode($inquiry->files, true) !== null)
                        @foreach (json_decode($inquiry->files) as $item)
                        <a href="/file/show/inquiry/{{ $inquiry->visit->uuid }}/{{ $item->filename }}" target="_blank">{{ $no++ }}. {{ $item->aliases }}</a><br>
                        @endforeach
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
                <table class="table table-bordered table-vcenter js-dataTable-simple" style="font-size:13px">
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
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @if(isset($inquiry->products))
                        @foreach ($inquiry->products as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}.</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="text-center">{{ $item->size }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-center">{{ $item->remark }}</td>
                        </tr>
                        @endforeach
                        @endif
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
                        {!! $inquiry->description !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
