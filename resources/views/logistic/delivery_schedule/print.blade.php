<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
        }

        label {
            font-size: 12px;
            margin-bottom: 0;
        }

        p {
            font-size: 13px;
        }

    </style>

</head>

<body>
    <div class="content">
        <div class="row">
            <div class="col-6">
                <img src="https://testing-prasasti.pt-prasasti.com/assets/logo.png" width="35%">
            </div>
            <div class="col-6">
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
                <label class="text-primary" style="font-weight: bold;"><b>DELIVERY ORDER {{ $query->transaction_code }}</b></label>
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">

                <div class="row">
                    <div class="col-2">
                        <label>PO No</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            {{ $query->transaction_code }}
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label>Date</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            {{ $query->delivery_date }}
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label>Terms</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            {{ $query->terms }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
                <label class="text-primary fs-2"><b>Address</b></label><br>
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
                <label> Jl. Prambanan 12cp 8/23 RT.07/14<br>
                    Satria Mekar, Tambun Utara, 17510 Bekasi<br>
                    <br>
                </label>
                <div class="row">
                    <div class="col-2">
                        <label>PIC</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            Retno Dhita
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label>Phone</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            085173218202
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label>Email</label>
                    </div>
                    <div class="col-1">
                        <label>:</label>
                    </div>
                    <div class="col-9">
                        <label>
                            info@pt-prasasti.com
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
                <label class="text-primary"><b>Ship To</b></label><br>
                <hr style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
                <label>
                    {{ $query->poc->quotation->sales_order->inquiry->visit->customer->company }} <br>
                    {{ $query->poc->quotation->sales_order->inquiry->visit->customer->address }}
                </label>
            </div>
        </div>

        <hr style="border-top: 1px black dashed">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="5%">
                        <p>No</p>
                    </th>
                    <th class="text-center">
                        <p>Item Description</p>
                    </th>
                    <th class="text-center" width="10%">
                        <p>Qty</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($query->delivery_schedule_items->sortBy('selected_sourcing_supplier.sourcing_supplier.inquiry_product.item_name') as $item)
                <tr>
                    <td class="text-center">
                        <p>{{ $loop->iteration }}</p>
                    </td>
                    <td>
                        <p>{{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->item_name }}, {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->description }}, {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->size }}, {{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->remark }}</p>
                        {{-- <p class="m-0">
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
                        </p> --}}
                    </td>
                    <td class="text-center">
                        <p>
                            {{ $item->selected_sourcing_supplier->sourcing_supplier->qty }}
                        </p>
                    </td>
                </tr>
                @endforeach
                @php
                $total = $item->selected_sourcing_supplier->sourcing_supplier->sum('qty');
                @endphp
                <tr>
                    <td colspan="1"></td>
                    <td class="text-right">
                        <p><b>Total / PCS</b></p>
                    </td>
                    <td class="text-center text-nowrap">
                        <p>
                            <b>
                                {{ $total }}
                            </b>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 footer">
        <div class="row">
            <div class="col-4">
                <p class="mb-0">Prepare By :</p>
                {{-- <img src="{{ asset('storage/' . $query->sales_order->inquiry->sales->sign) }}" alt="tanda-tangan"
                class="mt-2 mb-2" style="width: 200px; height: 80px;"> --}}
                <br>
                <br>
                <br>
                <p>
                    Husen
                    <br>
                    PT. Prambanan Sarana Sejati
                    <br>
                    Date : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y'); }}
                </p>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <div>
                    <p class="mb-0">Shipping By :</p>
                    {{-- <img src="{{ asset('storage/' . $query->sales_order->inquiry->sales->sign) }}" alt="tanda-tangan"
                    class="mt-2 mb-2" style="width: 200px; height: 80px;"> --}}
                    <br>
                    <br>
                    <br>
                    <p>
                        Husen
                        <br>
                        PT. Prambanan Sarana Sejati
                        <br>
                        Date : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y'); }}
                    </p>
                </div>
            </div>

            <div class="col-4 d-flex justify-content-end">
                <div>
                    <p class="mb-0">Received By :</p>
                    {{-- <img src="{{ asset('storage/' . $query->sales_order->inquiry->sales->sign) }}" alt="tanda-tangan"
                    class="mt-2 mb-2" style="width: 200px; height: 80px;"> --}}
                    <br>
                    <br>
                    <br>
                    <p>
                        {{ $query->poc->quotation->sales_order->inquiry->visit->customer->company }}
                        <br>
                        <br>
                        Date : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y'); }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p><strong>Note :</strong></p>
            </div>
            <div class="col-12">
                <div style="width: 100%; height: 100px; border: 1px solid black"></div>
            </div>
        </div>
    </div>


    <script>
        window.print();

    </script>
</body>

</html>
