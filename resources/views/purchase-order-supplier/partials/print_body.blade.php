<div class="text-center">
    <h5>
        <b>PURCHASE ORDER</b>
    </h5>
</div>

<div class="row">
    <div class="col-md-6 row">
        <div class="col-md-2">
            <label>
                <b>To</b>
            </label>
        </div>
        <div class="col-md-10">
            <div class="row">
                <label>
                    : {{ $query->supplier->company }}
                    <br> &nbsp {{ $query->supplier->address }}
                    <br>
                    <br>
                </label>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label>
                        Attn<br>
                        Telp<br>
                        Fax<br>
                        E-mail
                    </label>
                </div>
                <div class="col-sm-10">
                    <label>
                        : -
                        <br>: -
                        <br>: -
                        <br>: -
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 row">
        <div class="col-md-6">
            <label>
                No.PO
                <br>Date
                <br>Project
            </label>
        </div>
        <div class="col-md-6">
            <label>
                : {{ $query->transaction_code }}
                <br>: {{ $query->transaction_date }}
                <br>: PRASASTI
            </label>
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
                    <p class="m-0">
                        {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->item_name }}
                    </p>
                    <p class="m-0">
                        {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->description }}
                    </p>
                    <p class="m-0">
                        {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->size }}
                    </p>
                    <p class="m-0">
                        {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->remark }}
                    </p>
                </td>
                <td class="text-right">
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
        <?php
        $totalCost = $query->purchase_order_supplier_items->sum('price');
        $totalVat = 0;
        ?>
        @if ($query->vat === \App\Constants\VatTypeConstant::INCLUDE_11)
            <tr>
                <td colspan="3"></td>
                <td class="text-right">
                    <p><b>Subtotal</b></p>
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
                <td colspan="3"></td>
                <td class="text-right">
                    <p>
                        <b>{{ str_replace('Include ', '', $query->vat_to_text) }}</b>
                    </p>
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
        @endif
        <tr>
            <td colspan="3"></td>
            <td class="text-right">
                <p><b>Total</b></p>
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
    <div class="row">
        <div class="col-md-2">
            <label>
                Note
                <br>Term
                <br>Delivery
                <br>Payment Term
                <br>Document
            </label>
        </div>
        <div class="col-md-10">
            <label>
                :
                <br>: {{ $query->term }}
                <br>: {{ $query->delivery }}
                <br>: {{ $query->payment_term_to_text }}
                <br>: {{ $query->attachment }}
            </label>
        </div>
    </div>
</div>

<div class="mt-4">
    <p class="mb-0">Best Regards</p>
    @if ($query->sales_order->inquiry->sales->sign)
        <img src="{{ asset('storage/' . $query->sales_order->inquiry->sales->sign) }}" alt="tanda-tangan"
            class="mt-2 mb-2" style="width: 200px; height: 80px;">
    @else
        <br>
        <br>
        <br>
    @endif
    <p>
        {{ auth()->user()->name }}
        <br>Purchasing
    </p>
</div>
