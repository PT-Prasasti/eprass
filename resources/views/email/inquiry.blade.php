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
        <tr>
            <td style="width: 20%">Products</td>
            <td>:</td>
        </tr>


    </table>
    <table>
        <thead>
            <tr>
                <th>ITEM NAME</th>
                <th>MATERIAL DESCRIPTION</th>
                <th>SIZE</th>
                <th>QTY</th>
                <th>REMARK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['products'] as $p)
            <tr>
                <td>{{ $p->item_name }}</td>
            </tr>
            <tr>
                <td>{{ $p->description }}</td>
            </tr>
            <tr>
                <td>{{ $p->size }}</td>
            </tr>
            <tr>
                <td>{{ $p->qty }}</td>
            </tr>
            <tr>
                <td>{{ $p->remark }}</td>
            </tr>
            @endforeach
        </tbody>



    </table>
</body>

</html>