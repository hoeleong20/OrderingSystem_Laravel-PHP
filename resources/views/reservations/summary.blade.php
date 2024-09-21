<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservation Summary</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
</head>
<body>

    <div class="container">
        <h2>Reservation Summary</h2>

        <div class="alert alert-success">
            Your reservation was successful! Here are the details of your reservation:
        </div>

        <ul class="list-group">
            <li class="list-group-item"><strong>Reservation ID:</strong> {{ $reservation->id }}</li>
            <li class="list-group-item"><strong>Name:</strong> {{ $reservation->name }}</li>
            <li class="list-group-item"><strong>Phone:</strong> {{ $reservation->phone }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $reservation->email }}</li>
            <li class="list-group-item"><strong>Pax:</strong> {{ $reservation->pax }}</li>
            <li class="list-group-item"><strong>Date & Time:</strong> {{ $reservation->datetime->format('Y-m-d H:i') }}</li>
            <li class="list-group-item"><strong>Reservation Type:</strong> {{ ucfirst($reservation->reservation_type) }}</li>
        </ul>

        <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">Back to Home</a>
    </div>

    <!-- Include your JS files here -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>