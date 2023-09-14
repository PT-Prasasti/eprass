<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visit Schedule</title>
</head>
<body>
    <h4>Visit Schedule</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%">ID Visit</td>
            <td>: {{ $data['id'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Company</td>
            <td>: {{ $data['company'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Company Phone</td>
            <td>: {{ $data['company_phone'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Name</td>
            <td>: {{ $data['customer_name'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%" >Email</td>
            <td>: {{ $data['customer_email'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Phone</td>
            <td>: {{ $data['customer_phone'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Visit By</td>
            <td>: {{ $data['visit_by'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Created By</td>
            <td>: {{ $data['user_created'] }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Schedule</td>
            <td>: {{ $data['schedule'] }}</td>
        </tr>
    </table>
</body>
</html>