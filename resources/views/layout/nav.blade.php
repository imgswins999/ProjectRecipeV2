<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecipeShare')</title>
    <link rel="stylesheet" href="{{ asset('../includes/css/page.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

</head>

<body>
    @guest
        <nav class="navbar">
            <div class="nav-link">
                <li><a href="{{ route('recipe') }}">RECIPE</a></li>
                <li><a href="{{ route('popular') }}">POPULAR</a></li>
                <li><a href="{{ route('category') }}">CATEGORY</a></li>
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
                <li><a href="{{ route('recipe') }}">RECIPE</a></li>
                <li><a href="{{ route('popular') }}">POPULAR</a></li>
                <li><a href="{{ route('category') }}">CATEGORY</a></li>
            </div>

            <div class="nav-login">
                <li><a href="{{ route('writingView') }}">WRITING</a></li>
                <li><a href="#">HISTORY</a></li>
               <li><a href="{{ route('profile.show', ['id' => auth()->user()->user_id]) }}">PROFILE</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-btn">LOGOUT</button>s
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