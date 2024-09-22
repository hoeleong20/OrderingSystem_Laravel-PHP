<!-- resources/views/reservations/table_with_dish_reservation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserve Table with Dish</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>
<body>

    <div class="container">
        <h2>Reserve Table with Dish</h2>

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Customer Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pax">Number of Pax:</label>
                <input type="number" name="pax" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="datetime">Reservation Date & Time:</label>
                <input type="datetime-local" name="datetime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="dishes">Select Dishes:</label>
                <select name="dish_id[]" class="form-control" multiple required>
                    @foreach ($menuItems as $menuItem)
                        <option value="{{ $menuItem->id }}">{{ $menuItem->name }} - ${{ $menuItem->price }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="reservation_type" value="table_with_dish">

            <button type="submit" class="btn btn-primary">Reserve Table with Dish</button>
        </form>
    </div>

</body>
</html>