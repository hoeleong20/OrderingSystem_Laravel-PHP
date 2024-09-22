{{-- Author : Khor Zhi Ying --}}
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Rating</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>
<body>

    <div class="container mt-5">
        <a class="nav-link" href="{{ route('welcome') }}">Home </a>
        <h1>Restaurant Rating</h1>

        <!-- Display the fetched rating -->
        <p>The current average rating of the restaurant is: <strong>{{ $rating }}</strong></p>
    </div>
</body>
</html>
