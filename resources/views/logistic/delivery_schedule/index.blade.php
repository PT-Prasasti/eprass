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
                    <i class="fa fa-plus mr-5"></i>Add Data
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
                            @php
                            $badgeColor = '';
                            switch ($do->status) {
                            case 'On Progress':
                            $badgeColor = 'warning';
                            break;
                            case 'Done':
                            $badgeColor = 'success';
                            break;
                            default:
                            $badgeColor = 'danger';
                            }
                            @endphp
                            <td class="text-center">
                                <button id="statusBtn_{{ $do->id }}" class="btn btn-{{ $badgeColor }} btn-sm" data-toggle="modal" data-target="#modal_{{ $do->id }}">{{ $do->status }}</button>
                            </td>
                            <td class="text-center">
                                <a type="button" href="{{ route('logistic.delivery_order.view', $do->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-title="View">
                                    <i class="fa fa-file"></i>
                                </a> |
                                <a type="button" href="{{ route('logistic.delivery_order.print', $do->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-title="Print">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal_{{ $do->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_{{ $do->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popin" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('logistic.delivery_order.update_status', $do->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">Status PO Tracking</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                        <i class="si si-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content text-center">
                                                <select class="form-control" id="statusDO{{ $do->id }}" name="status">
                                                    <option value="0" selected disabled>-- Please Select --</option>
                                                    <option value="On Progress" {{ $do->status == 'On Progress' ? 'selected' : '' }}>
                                                        On Progress</option>
                                                    <option value="Done" {{ $do->status == 'Done' ? 'selected' : '' }}>Done
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer mt-5">
                                            <button type="submit" class="btn btn-primary"">
                                                    <i class=" fa fa-save"></i> SAVE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
