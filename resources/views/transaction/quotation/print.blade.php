<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        label {
            font-size: 12px;
        }

        p {
            font-size: 13px;
        }
    </style>

</head>

<body>
    <div class="row">
        <div class="col-md-8">
            <img src="https://testing-prasasti.pt-prasasti.com/assets/logo.png" width="35%">
        </div>
        <div class="col-md-4">
            <label class="text-primary"><b>PT. Prambanan Sarana Sejati</b></label><br>
            <label> Satria Square A-02<br>
                Jl. Raya Karang Satria No.Kav. 10,<br>
                Karangsatria, Kec. Tambun Utara,<br>
                Kabupaten Bekasi, Jawa Barat 17510<br>
                Phone : 021 - 82782888<br>
                email : info@pt-prasasti.com<br>
            </label>
        </div>
    </div>

    <hr style="border-top: 2px solid #000;">
    <hr style="border-top: 2px solid #000; margin-top:-10px;">

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
                <label>: {{ $query->sales_order->inquiry->visit->customer->company }} <br>
                    &nbsp {{ $query->sales_order->inquiry->visit->customer->address }} <br> <br>
                    : {{ $query->sales_order->inquiry->visit->customer->name ?? '-' }} <br>
                    : -<br>
                    : {{ $query->sales_order->inquiry->subject ?? '-' }}<br>
                    : {{ $query->sales_order->inquiry->visit->customer->phone ?? '-' }}<br>
                    : {{ $query->sales_order->inquiry->visit->customer->company_fax ?? '-' }}<br>
                    : {{ $query->sales_order->inquiry->visit->customer->email ?? '-' }}<br>
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
        <p>We thank you for your inquiry and we are pleased to submit our best offer for your kind consideration :</p>
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
            @foreach ($query->sales_order->sourcing->selected_sourcing_suppliers as $item)
                <tr>
                    <td class="text-center">
                        <p>{{ $loop->iteration }}</p>
                    </td>
                    <td>
                        <p>
                            {{ $item->sourcing_supplier->inquiry_product->item_name }}
                        </p>
                        <p></p>
                    </td>
                    <td class="text-right">
                        <p>{{ $item->sourcing_supplier->inquiry_product->sourcing_qty }}</p>
                    </td>
                    <td class="text-right text-nowrap">
                        <p>
                            Rp
                            {{ number_format($item->sourcing_supplier->inquiry_product->quotation_item->cost, 2, ',', '.') }}
                        </p>
                    </td>
                    <td class="text-right text-nowrap">
                        <p>
                            Rp
                            {{ number_format($totalCost += $item->sourcing_supplier->inquiry_product->quotation_item->total_cost, 2, ',', '.') }}
                        </p>
                    </td>
                    <td>
                        <p>{{ $item->sourcing_supplier->inquiry_product->delivery_time }}</p>
                    </td>
                </tr>
            @endforeach
            <?php
            $totalVat = 0;
            ?>
            @if ($query->vat === \App\Constants\VatTypeConstant::INCLUDE_11)
                <tr>
                    <td colspan="4" class="text-right">
                        <p><b>{{ str_replace('Include ', '', $vatTypes[$query->vat]) }}</b></p>
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
                <td colspan="3">Lampiran: {{ $query->attachment }}</td>
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
            Equipment qouted is based on the information provided by your goodselves. We reserve the right<br>
            to re-qouted should there be any deviations/clarifications or upon receipt of detail specifications.<br>
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
            Please confirm our selection. If you require information, please do not hesitate to contact us.<br>
        </label>
    </div>

    <div class="mt-4">
        <p>Best Regards</p>

        <p>Retno Dhita</p>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
