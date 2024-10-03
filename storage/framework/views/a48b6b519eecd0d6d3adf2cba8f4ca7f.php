<!-- Author Khor Zhi Ying  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservation Summary</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>">
</head>

<body>

    <div class="container">
        <h2>Reservation Summary</h2>

        <div class="alert alert-success">
            Your reservation was successful! Here are the details of your reservation:
        </div>

        <ul class="list-group">
            <li class="list-group-item"><strong>Reservation ID:</strong> <?php echo e($reservation->id); ?></li>
            <li class="list-group-item"><strong>Name:</strong> <?php echo e($reservation->name); ?></li>
            <li class="list-group-item"><strong>Phone:</strong> <?php echo e($reservation->phone); ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo e($reservation->email); ?></li>
            <li class="list-group-item"><strong>Pax:</strong> <?php echo e($reservation->pax); ?></li>
            <li class="list-group-item"><strong>Date & Time:</strong> <?php echo e($reservation->datetime->format('Y-m-d H:i')); ?></li>
            <li class="list-group-item"><strong>Reservation Type:</strong> <?php echo e(ucfirst($reservation->reservation_type)); ?></li>
            <?php if($reservation->reservation_type === 'dish'): ?>
            <li class="list-group-item"><strong>Dish IDs:</strong> <?php echo e($reservation->extra_info); ?></li>
            <?php elseif($reservation->reservation_type === 'table'): ?>
            <li class="list-group-item"><strong>Table Number:</strong> <?php echo e($reservation->extra_info); ?></li>
            <?php elseif($reservation->reservation_type === 'event'): ?>
            <li class="list-group-item"><strong>Event Details:</strong> <?php echo e($reservation->extra_info); ?></li>
            <?php endif; ?>
        </ul>

        <a href="<?php echo e(route('welcome')); ?>" class="btn btn-primary mt-3">Back to Home</a>
    </div>

    <script src="<?php echo e(asset('js/bootstrap.js')); ?>"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\RestaurantOrderingSystem-main\resources\views/reservations/summary.blade.php ENDPATH**/ ?>