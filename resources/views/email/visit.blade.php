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
    <label>ID Visit</label>
    <p>{{ $data->id }}</p>
    <label>Company</label>
    <p>{{ $data->company_name }}</p>
    <label>Company Phone</label>
    <p>{{ $data->company_phone }}</p>
    <label>Name</label>
    <p>{{ $data->customer_name }}</p>
    <label>Email</label>
    <p>{{ $data->customer_email }}</p>
    <label>Phone</label>
    <p>{{ $data->customer_phone }}</p>
    <label>Visit By</label>
    <p>{{ $data->visit_by }}</p>
</body>
</html>