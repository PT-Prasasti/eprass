<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    <b>
                    List Delivery Scheduler
                    </b>
                </h4>
            </div>
            <div class="col-md-6 text-right">
                <a type="button" class="btn btn-primary mr-5 mb-5" href="{{ route('logistic.delivery_order.add') }}">
                    <i class="fa fa-save mr-5"></i>Add Data
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

        <div class="block block-rounded">
            <div class="block-content block-content-full table-responsive">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Cust Number</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Delivery Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliverySchedule as $do)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $do->po_customer_id }}</td>
                            <td class="text-center">{{ $do->poc->quotation->sales_order->inquiry->visit->customer->name }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($do->poc->quotation->sales_order->inquiry->due_date)->format('d M Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($do->delivery_date)->format('d M Y') }}</td>
                            <td class="text-center">{{ $do->poc->status }}</td>
                            <td class="text-center">
                                <a type="button" href="form_app.php" class="btn btn-sm btn-primary" data-toggle="tooltip">
                                    <i class="fa fa-file"></i>
                                </a> |
                                <a type="button" href="form_app.php" class="btn btn-sm btn-warning" data-toggle="tooltip">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div hidden>
        <form id="form-delete" action="" method="POST">
            @csrf
            @method('delete')
        </form>
    </div>

    <x-slot name="js">
        <script>

        </script>
    </x-slot>
</x-app-layout>
