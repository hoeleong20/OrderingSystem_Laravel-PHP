
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservations</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> <!-- Example of Bootstrap -->
</head>
<body>

    <div class="container">
        <h2>All Reservations</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Pax</th>
                    <th>Datetime</th>
                    <th>Reservation Type</th>
                    <th>Extra Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->name }}</td>
                        <td>{{ $reservation->email }}</td>
                        <td>{{ $reservation->phone }}</td>
                        <td>{{ $reservation->pax }}</td>
                        <td>{{ $reservation->datetime->format('Y-m-d H:i:s') }}</td>
                        <td>{{ ucfirst($reservation->reservation_type) }}</td>
                        <td>{{ $reservation->extra_info }}</td>
                        <td>
                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include your JS files here -->
    <script src="{{ asset('js/bootstrap.js') }}"></script> <!-- Example of Bootstrap JS -->
</body>
</html>