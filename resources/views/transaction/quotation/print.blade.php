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

    @include('transaction.quotation.partials.print_body')

    <script>
        window.print();
    </script>
</body>

</html>
