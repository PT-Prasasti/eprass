<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <h4><b>{{ $query->transaction_code }}</b></h4>
            </div>
            @if($query->status !== 'Approved By Manager' && $query->status !== 'Rejected By Manager')
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success mr-5 mb-5">
                    <a href="{{ route('approval-po.approve', $query->id) }}" class="text-white">
                        <i class="fa fa-save mr-5"></i>Approve
                    </a>
                </button>
                <button type="button" class="btn btn-danger mr-5 mb-5" data-toggle="modal" data-target="#modal-reject">
                    <i class="fa fa-ban mr-5"></i>
                    Rejected
                </button>
            </div>
            @endif
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
                            <a class="nav-link" href="#document">Document</a>
                        </li>
                    </ul>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12 text-center" style="margin-top:-8px">
                                    <h5>PURCHASE ORDER</h5>
                                </div>

                                <div class="col-sm-12 text-center" style="margin-top:-8px">
                                    <hr style="border-top: 4px solid #000; margin-top:-5px;">
                                </div>

                                <div class="col-sm-8 row">
                                    <div class="col-sm-2">
                                        <label>To</label><br>
                                        <label class="text-white">p</label><br><br>
                                        <label>Attn</label><br>
                                        <label>Telp</label><br>
                                        <label>Fax</label><br>
                                        <label>Email</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <label>: {{ $query->supplier->company }}</label><br>
                                        <label>: {{ $query->supplier->address }}</label><br><br>
                                        <label>:{{ $query->supplier->company }}</label><br>
                                        <label>: {{ $query->supplier->company_phone }}</label><br>
                                        <label>: -</label><br>
                                        <label>: {{ $query->supplier->company_email }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-4 row">
                                    <div class="col-sm-3">
                                        <label>No. PO</label><br>
                                        <label>Date</label><br>
                                        <label>Project</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <label>: {{ $query->transaction_code }}</label><br>
                                        <label>: {{ $query->transaction_date }}</label><br>
                                        <label>: PRASASTI</label>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <p>No</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Description</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Qty</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Unit Price</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Total Price</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalCost = 0;
                                    ?>
                                    @foreach ($query->purchase_order_supplier_items->sortBy('selected_sourcing_supplier.sourcing_supplier.inquiry_product.item_name') as $item)
                                    <tr>
                                        <td class="text-center">
                                            <p>{{ $loop->iteration }}</p>
                                        </td>
                                        <td>
                                            <label>Item Name - {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->item_name }}</label><br>
                                            <label>Material Description - {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->description }}</label><br>
                                            <label>Size - {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->size }}</label><br>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $item->quantity }}
                                            </p>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>
                                                Rp
                                                {{ number_format($item->cost, 2, ',', '.') }}
                                            </p>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>
                                                Rp
                                                {{ number_format($item->price, 2, ',', '.') }}
                                            </p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">Document: Berkas - Berkas</td>
                                    </tr>
                                    <?php
                                    $totalCost = $query->purchase_order_supplier_items->sum('price');
                                    $totalVat = 0;
                                    ?>
                                    @if ($query->vat === \App\Constants\VatTypeConstant::INCLUDE_11)
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <p><b>Total</b></p>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>
                                                <b>
                                                    Rp
                                                    {{ number_format($totalCost, 2, ',', '.') }}
                                                </b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <b>{{ str_replace('Include ', '', $query->vat_to_text) }}</b>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>
                                                <b>
                                                    Rp
                                                    {{ number_format($totalVat = ($totalCost * 11) / 100, 2, ',', '.') }}
                                                </b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <p><b>Grand Total</b></p>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>
                                                <b>
                                                    Rp
                                                    {{ number_format($totalVat += $totalCost, 2, ',', '.') }}
                                                </b>
                                            </p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-2">
                                <label>
                                    Equipment qouted is based on the information provided by your
                                    goodselves. We reserve the right<br>
                                    to re-qouted should there be any deviations/clarifications or upon
                                    receipt of detail specifications.<br>
                                </label>
                            </div>

                            <div class="mt-2">
                                <hr style="border-top: 1px solid #000; margin-top: -10px">
                                <hr style="border-top: 1px solid #000; margin-top: -12px">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>
                                            1. Note<br>
                                            2. Term<br>
                                            3. Delivery<br>
                                            4. Payment Term<br>
                                            5. Document
                                        </label>
                                    </div>
                                    <div class="col-md-1">
                                        <label>
                                            : <br>
                                            : <br>
                                            : <br>
                                            : <br>
                                            : <br>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <label>
                                            {{ $query->note }}<br>
                                            {{ $query->term }}<br>
                                            {{ $query->delivery }}<br>
                                            {{ strtoupper(str_replace('_', ' ', $query->payment_term)) }}<br>
                                            {{ $query->attachment }}<br>
                                        </label>
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid #000; margin-top: -3px">
                                <hr style="border-top: 1px solid #000; margin-top: -12px">
                            </div>

                        </div>

                        <div class="tab-pane" id="document" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f1">INQUIRY</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f2">SALES ORDER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f3">SOURCING ITEM</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PO CUSTOMER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PO SUPPLIER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PURCHASING DOCUMENT</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modal-reject" aria-hidden="true">
        <form method="PUT" action="{{ route('approval-po.reject', $query->id) }}">
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
</x-app-layout>
