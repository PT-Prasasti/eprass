<x-app-layout>

    <div class="content">

        <input type="hidden" name="uuid" value="{{ $so->uuid }}">
        <div class="row">
            <div class="col-md-6">
                <h4><b>SO NUMBER : <span id="id">{{ $so->id }}</span></b></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-content block-content-full bg-pattern">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">ID Inquiry</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="inquiry"
                                            value="{{ $so->inquiry->id }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Sales Name</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="sales"
                                            value="{{ $so->inquiry->sales->name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Company Name</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="company"
                                            value="{{ $so->inquiry->visit->customer->company }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Phone & Email</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $so->inquiry->visit->customer->phone }}" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="email"
                                            value="{{ $so->inquiry->visit->customer->email }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Telp</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="company_phone"
                                            value="{{ $so->inquiry->visit->customer->company_phone }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subject</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="subject"
                                            value="{{ $so->inquiry->subject }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Due Date</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="due_date"
                                            value="{{ Carbon\Carbon::parse($so->due_date)->format('d M Y') }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Grade</label>
                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="grade"
                                            value="{{ $so->inquiry->grade }}" disabled>
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
                            @php
                                $no = 1;
                            @endphp
                            @if (json_decode($so->inquiry->files, true) !== null)
                                @foreach (json_decode($so->inquiry->files) as $item)
                                    <a href="/file/show/inquiry/{{ $so->inquiry->visit->uuid }}/{{ $item->filename }}"
                                        target="_blank">{{ $no++ }}. {{ $item->aliases }}</a><br>
                                @endforeach
                            @endif
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
                        <div class="push">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download
                                        Product List</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"
                                        x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item"
                                            href="{{ route('transaction.sales-order.download-product-list-excel', ['id' => $so->inquiry->uuid]) }}">
                                            Excel
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('transaction.sales-order.download-product-list-pdf', ['id' => $so->inquiry->uuid]) }}">
                                            PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        @if (isset($so->inquiry->products))
                            @foreach ($so->inquiry->products as $item)
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
                    <div class="col-12" id="note">
                        {!! $so->inquiry->description !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>
            var uuid = ''

            $(document).ready(function() {
                getPdf("{{ $so->inquiry->uuid }}")
            })

            function getPdf(id) {
                $.ajax({
                    url: "{{ route('transaction.sales-order.get-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        // console.log(response.data);
                        // listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            // function listItemPdf(status, data) {
            //     if (status == 200) {
            //         var element = ``
            //         var number = 1
            //         var visit = $('select[name=inquiry]').val()
            //         $.each(data, function(index, value) {
            //             element += `<li class="list-group-item">
    //                             <div class="d-flex justify-content-between align-items-center">
    //                                 <a href="/file/show/inquiry/${uuid}/${value.filename}" target="_blank">` +
            //                 number + `. ` + value.aliases + `</a>
    //                             </div>
    //                         </li>`
            //             number++
            //         })
            //         $('.list-group').html(``)
            //         $('.list-group').html(element)
            //         $('input[name=pdf]').val(JSON.stringify(data))
            //     }
            // }
        </script>
    </x-slot>

</x-app-layout>
