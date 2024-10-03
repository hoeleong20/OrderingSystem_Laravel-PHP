<!-- Author : Lim Jia Qing -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Menus</title>
</head>
<body>
    <h2>Activate Menus</h2>

    <!-- Display the transformed HTML from XSLT -->
    <div>
        {!! $transformedHtml !!}
    </div>

    <!-- Form to activate all menus at once -->
    <form method="POST" action="{{ route('menus.activateAll') }}">
        @csrf
        <button type="submit" class="btn btn-success">Activate All Menus</button>
    </form>

    <!-- Back button to navigate back to the Admin Menu -->
    <a href="{{ route('menus.adminMenu') }}" class="btn btn-secondary">Back</a>
</body>
</html>
