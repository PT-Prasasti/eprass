<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inquiry</title>
</head>

<body>
    <h4>Inquiry</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%">ID Inquiry</td>
            <td>: {{ $data['id'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">ID Visit</td>
            <td>: {{ $data['id_visit'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Due Date</td>
            <td>: {{ \Carbon\Carbon::parse($data['due_date'])->format('d-M-Y') }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Subject</td>
            <td>: {{ $data['subject'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Grade</td>
            <td>: {{ $data['grade'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Description</td>
            <td>: {{ $data['description'] }}</td>
        </tr>
        <tr style="vertical-align: top">
            <td style="width: 20%">Product List</td>
            <td>: <table style="width: 100%; border: 1px solid;">
                    <thead>
                        <tr>
                            <th style="width: 20%; border: 1px solid;">ITEM NAME</th>
                            <th style="width: 20%; border: 1px solid;">MATERIAL DESCRIPTION</th>
                            <th style="width: 20%; border: 1px solid;">SIZE</th>
                            <th style="width: 20%; border: 1px solid;">QTY</th>
                            <th style="width: 20%; border: 1px solid;">REMARK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['products'] as $p)
                        <tr>
                            <td style="border: 1px solid;">{{ $p->item_name }}</td>
                            <td style="border: 1px solid;">{{ $p->description }}</td>
                            <td style="border: 1px solid;">{{ $p->size }}</td>
                            <td style="border: 1px solid;">{{ $p->qty }}</td>
                            <td style="border: 1px solid;">{{ $p->remark }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>


    </table>

    <br>

</body>

</html>