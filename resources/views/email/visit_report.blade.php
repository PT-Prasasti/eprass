<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visit Report</title>
</head>
<body>
    <h4>Visit Schedule</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%">ID Visit</td>
            <td>: {{ $data['id'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Date & Time</td>
            <td>: {{ \Carbon\Carbon::parse($data['date'])->format('d-M-Y') }} & {{ \Carbon\Carbon::parse($data['time'])->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Customer - Company Name</td>
            <td>: {{ $data['customer_company'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Phone</td>
            <td>: {{ $data['customer_phone'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Email</td>
            <td>: {{ $data['customer_email'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Status</td>
            <td>: {{ $data['status'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Note / Description</td>
            <td>: {{ $data['note'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Planning</td>
            <td>: {{ $data['plan'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Created By</td>
            <td>: {{ $data['sales'] }}</td>
        </tr>
    </table>
</body>
</html>