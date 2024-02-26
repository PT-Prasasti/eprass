<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List PO Tracking</b></h4>
            </div>
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
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full table-responsive" id="viewTable">
                <table id="table-po-tracking" class="table table-striped table-vcenter" style="font-size:13px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Customer Name - Company Name</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">DD to Customer</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td class="text-center">{{ $item->purchase_order_supplier->transaction_code }}</td>
                            <td class="text-center">
                                {{ $item->purchase_order_supplier->sales_order->inquiry->visit->customer->name }} -
                                {{ $item->purchase_order_supplier->sales_order->inquiry->visit->customer->company }}
                            </td>
                            <td class="text-center">{{ $item->purchase_order_supplier->supplier->company }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->purchase_order_supplier->sales_order->inquiry->due_date)->format('d F Y') }}
                            </td>
                            @php
                            $badgeColor = '';
                            switch ($item->status) {
                            case 'Shipping to Jakarta':
                            $badgeColor = 'warning';
                            break;
                            case 'Custome Process':
                            $badgeColor = 'primary';
                            break;
                            case 'Shipping to PRASASTI':
                            $badgeColor = 'secondary';
                            break;
                            case 'Done':
                            $badgeColor = 'success';
                            break;
                            default:
                            $badgeColor = 'danger';
                            }
                            @endphp
                            @if(auth()->user()->hasRole('exim'))
                            <td class="text-center">
                                <button id="statusBtn_{{ $item->id }}" class="btn btn-{{ $badgeColor }} btn-sm" data-toggle="modal" data-target="#modal_{{ $item->id }}">{{ $item->status }}</button>
                            </td>
                            @else
                            <td class="text-center">
                                <div class="badge badge-{{ $badgeColor }}">{{ $item->status }}</div>
                            </td>
                            @endif
                            <td class="text-center">
                                @if(auth()->user()->hasRole('exim'))
                                <a type="button" href="{{ route('po-tracking.view', $item->uuid) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail PO Tracking">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                                @else
                                <a type="button" href="{{ route('po-tracking.open', $item->uuid) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Open PO Tracking">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="modal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popin" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('po-tracking.update_status', $item->id) }}" method="POST">
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
                                                <select class="form-control" id="statusTracking{{ $item->id }}" name="status">
                                                    <option value="0">-- Please Select --</option>
                                                    <option value="Shipping to Jakarta" {{ $item->status == 'Shipping to Jakarta' ? 'selected' : '' }}>
                                                        Shipping to Jakarta</option>
                                                    <option value="Custome Process" {{ $item->status == 'Customer Process' ? 'selected' : '' }}>
                                                        Custome Process</option>
                                                    <option value="Shipping to PRASASTI" {{ $item->status == 'Shipping to PRASASTI' ? 'selected' : '' }}>
                                                        Shipping to PRASASTI</option>
                                                    <option value="Done" {{ $item->status == 'Done' ? 'selected' : '' }}>Done
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

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                $('#table-po-tracking').dataTable();
            })

        </script>
    </x-slot>
</x-app-layout>
