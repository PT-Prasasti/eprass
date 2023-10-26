<div class="text-center" style="margin-top:-8px">
    <h5>QUOTATION</h5>
</div>

<hr style="border-top: 4px solid #000; margin-top:-5px;">

<div class="row">
    <div class="col-md-6 row">
        <div class="col-md-2">
            <label> To
                <br>
                <br>
                <br>
                Attn<br>
                Reff<br>
                Subject<br>
                Phone<br>
                Fax<br>
                E-mail
            </label>
        </div>
        <div class="col-md-10">
            <label>:
                {{ $query->sales_order->inquiry->visit->customer->company }}
                <br>
                &nbsp
                {{ $query->sales_order->inquiry->visit->customer->address }}
                <br> <br>
                :
                {{ $query->sales_order->inquiry->visit->customer->name ?? '-' }}
                <br>
                : -<br>
                : {{ $query->sales_order->inquiry->subject ?? '-' }}<br>
                :
                {{ $query->sales_order->inquiry->visit->customer->phone ?? '-' }}<br>
                :
                {{ $query->sales_order->inquiry->visit->customer->company_fax ?? '-' }}<br>
                :
                {{ $query->sales_order->inquiry->visit->customer->email ?? '-' }}<br>
            </label>
        </div>
    </div>
    <div class="col-md-6 row">
        <div class="col-md-6">
            <label> No<br>
                Date<br>
                Qutation Valid Until<br>
                Prepared by<br>
                Sales Rep<br>
                Phone
            </label>
        </div>
        <div class="col-md-6">
            <label> : {{ $query->quotation_code }}<br>
                : {{ date('Y-m-d') }}<br>
                : {{ date('Y-m-d', strtotime($query->due_date)) }}<br>
                : {{ $query->sales_order->inquiry->sales->name }}<br>
                : {{ $query->sales_order->inquiry->sales->name }}<br>
                : {{ $query->sales_order->inquiry->sales->phone }}<br>
            </label>
        </div>
    </div>
</div>

<div class="mt-3">
    <p>We thank you for your inquiry and we are pleased to submit our best offer
        for your kind consideration :</p>
</div>


<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <p>No</p>
            </th>
            <th class="text-center">
                <p>Item Name</p>
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
            <th class="text-center">
                <p>Delivery Time</p>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalCost = 0;
        ?>
        @foreach ($query->quotation_items as $item)
            <tr>
                <td class="text-center">
                    <p>{{ $loop->iteration }}</p>
                </td>
                <td>
                    <p class="m-0">
                        {{ $item->inquiry_product->item_name }}
                    </p>
                    <p class="m-0">
                        {{ $item->inquiry_product->description }}
                    </p>
                    <p class="m-0">
                        {{ $item->inquiry_product->size }}
                    </p>
                    <p class="m-0">
                        {{ $item->inquiry_product->remark }}
                    </p>
                </td>
                <td class="text-right">
                    <p>
                        {{ $item->inquiry_product->sourcing_qty }}
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
                        {{ number_format($item->total_cost, 2, ',', '.') }}
                    </p>
                </td>
                <td>
                    <p>
                        {{ $item->inquiry_product->delivery_time }}
                    </p>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">Document: {{ $query->attachment }}</td>
            <td colspan="3"></td>
        </tr>
        <?php
        $totalCost = $query->quotation_items->sum('total_cost');
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
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-right">
                    <p><b>{{ str_replace('Include ', '', $vatTypes[$query->vat]) }}</b>
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
                <td></td>
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
            <td></td>
        </tr>
    </tbody>
</table>

<div class="mt-2">
    <label>
        Remarks :<br>
        Equipment qouted is based on the information provided by your
        goodselves. We reserve the right<br>
        to re-qouted should there be any deviations/clarifications or upon
        receipt of detail specifications.<br>
    </label>
</div>

<div class="mt-2">
    <p><b>Terms & Conditions</b></p>
    <hr style="border-top: 1px solid #000; margin-top: -10px">
    <hr style="border-top: 1px solid #000; margin-top: -12px">
    <div class="row">
        <div class="col-md-2">
            <label>
                1. Price<br>
                2. Delivery Term<br>
                3. Term of Payment<br>
                4. Validity<br>
                5. VAT
            </label>
        </div>
        <div class="col-md-10">
            <label>
                : IDR Basis <br>
                : {{ $query->delivery_term }} <br>
                : {{ $paymentTerms[$query->payment_term] }} <br>
                : {{ $query->validity }} <br>
                : {{ $vatTypes[$query->vat] }} <br>
            </label>
        </div>
    </div>
    <hr style="border-top: 1px solid #000; margin-top: -3px">
    <hr style="border-top: 1px solid #000; margin-top: -12px">
</div>

<div class="mt-2">
    <label>
        Price subject to change if quantity is changed.<br>
        Please confirm our selection. If you require information, please do not
        hesitate to contact us.<br>
    </label>
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
    <p>{{ $query->sales_order->inquiry->sales->name }}</p>
</div>
