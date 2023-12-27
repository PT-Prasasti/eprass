<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #qrCodeImage {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <img src="{{ url('/') }}/storage/cloud-storage/qr/{{ $qrCodeUrl }}" id="qrCodeImage">

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>
</html>
