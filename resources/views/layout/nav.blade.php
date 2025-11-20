<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecipeShare')</title>
    <link rel="stylesheet" href="{{ asset('../includes/css/page.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>
    @guest
        <nav class="navbar">
            <div class="nav-link">
                <li><a href="#">RECIPE</a></li>
                <li><a href="#">POPULAR</a></li>
                <li><a href="#">CATEGORY</a></li>
            </div>

            <div class="nav-login">
                <li><a href="{{ route('signIn') }}">LOGIN</a></li>
                <li><a href="{{ route('signUp') }}">REGISTER</a></li>
            </div>
        </nav>
    @endguest

    @auth
        <nav class="navbar">
            <div class="nav-link">
                <li><a href="#">RECIPE</a></li>
                <li><a href="#">POPULAR</a></li>
                <li><a href="#">CATEGORY</a></li>
            </div>

            <div class="nav-login">
                <li><a href="#">WRITING</a></li>
                <li><a href="#">HISTORY</a></li>
                <li><a href="#">PROFILE</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-btn">LOGOUT</button>
                    </form>
                </li>
            </div>
        </nav>
    @endauth
    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2025 Recipe Share</p>
    </footer>
</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js">
</script>
<script>
    AOS.init();
</script>

</html>