<!-- resources/views/reservations/dish_reservation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserve a Dish</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>
<body>

    <div class="container">
        <h2>Reserve a Dish</h2>

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
            <label for="dishes">Select Dishes:</label>
            <select name="dish_id[]" class="form-control" multiple required>
                <option value="dish-1">Spaghetti Bolognese</option>
                <option value="dish-2">Grilled Chicken</option>
                <option value="dish-3">Caesar Salad</option>
                <option value="dish-4">Margherita Pizza</option>
                <option value="dish-5">Beef Steak</option>
            </select>
        </div>

            <input type="hidden" name="reservation_type" value="dish">

            <button type="submit" class="btn btn-primary">Reserve Dish</button>
        </form>
    </div>

</body>
</html>