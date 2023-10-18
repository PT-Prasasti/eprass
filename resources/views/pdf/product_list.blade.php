<!DOCTYPE html>
<html>

<head>
    <title>Product List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            /* Thin black border */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">SO : {{ $so }}</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 2%;">No</th>
                <th style="width: 16%;">Item Name</th>
                <th style="width: 32%;">Description</th>
                <th style="width: 20%">Size</th>
                <th style="width: 10%">Quantity</th>
                <th>Remark</th>
                <th>Unit Price</th>
                <th>Delivery Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $item[0] }}</td>
                    <td>{{ $item[1] }}</td>
                    <td>{!! nl2br(e($item[2])) !!}</td>
                    <td>{{ $item[3] }}</td>
                    <td style="text-align: right;">{{ $item[4] }}</td>
                    <td>{!! nl2br(e($item[5])) !!}</td>
                    <td>{{ $item[6] ?? '' }}</td>
                    <td>{{ $item[7] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
