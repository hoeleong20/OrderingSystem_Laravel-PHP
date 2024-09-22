<!-- Author Khor Zhi Ying  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Reservation</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> <!-- Example of Bootstrap -->
</head>
<body>

    <div class="container">
        <h2>Edit Reservation</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- This method is used for updating the record -->

            <div class="form-group">
                <label for="name">Customer Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $reservation->name }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" class="form-control" value="{{ $reservation->phone }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="{{ $reservation->email }}" required>
            </div>

            <div class="form-group">
                <label for="pax">Number of Pax:</label>
                <input type="number" name="pax" class="form-control" value="{{ $reservation->pax }}" required>
            </div>

            <div class="form-group">
                <label for="datetime">Reservation Date & Time:</label>
                <input type="datetime-local" name="datetime" class="form-control" value="{{ $reservation->datetime->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="form-group">
                <label for="reservation_type">Reservation Type:</label>
                <select name="reservation_type" class="form-control" required>
                    <option value="table" {{ $reservation->reservation_type == 'table' ? 'selected' : '' }}>Table</option>
                    <option value="table_with_dish" {{ $reservation->reservation_type == 'table_with_dish' ? 'selected' : '' }}>Table with Dish</option>
                    <option value="dish" {{ $reservation->reservation_type == 'dish' ? 'selected' : '' }}>Dish</option>
                    <option value="event" {{ $reservation->reservation_type == 'event' ? 'selected' : '' }}>Event</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Reservation</button>
        </form>
    </div>

    <!-- Include your JS files here -->
    <script src="{{ asset('js/bootstrap.js') }}"></script> <!-- Example of Bootstrap JS -->
</body>
</html>