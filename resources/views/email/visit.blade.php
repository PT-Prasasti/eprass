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
    <table style="width: 50%">
        <tr>
            <td>ID Visit</td>
            <td>{{ $data['id'] }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $data['company'] }}</td>
        </tr>
        <tr>
            <td>Company Phone</td>
            <td>{{ $data['company_phone'] }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $data['customer_name'] }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $data['customer_email'] }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $data['customer_phone'] }}</td>
        </tr>
        <tr>
            <td>Visit By</td>
            <td>{{ $data['visit_by'] }}</td>
        </tr>
    </table>
</body>
</html>