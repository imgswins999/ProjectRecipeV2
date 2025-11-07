<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecipeShare')</title>
    <link rel="stylesheet" href="{{ asset('../includes/css/navbar.css') }}">
</head>

<body>
    <nav class="navbar">
        <li><a href="#">RECIPE</a></li>
        <li><a href="#">RECIPE</a></li>
        <li><a href="#">RECIPE</a></li>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2025 Recipe Share</p>
    </footer>
</body>

</html>