<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN IN</title>
    <link rel="stylesheet" href="{{ asset('./includes/css/signInAndSignUp.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>

    <div class="container-signUp">
        <form>
            <div class="signIn-box" div data-aos="fade-down">
                <!-- USERNAME -->
                <div class="imageLogo">
                    <img src="{{asset('includes/images/logo4.png')}}" alt="" width="400px">
                </div>

                <div class="username-box">
                    <p>USERNAME</p>
                    <input type="text" name="username" id="username" required placeholder="username / e-mail"
                        class="input-signIn">
                </div>
                <!-- PASSWORD -->
                <div class="password-box">
                    <p>PASSWORD</p>
                    <input type="password" name="password" id="password" required placeholder="password"
                        class="input-signIn">
                </div>
                <!-- BUTTON -->
                <div class="button-sign">
                    <button type="submit" class="bt-signIn">SIGN IN</button>
                    <div class="signUp">
                        <p>Don't have a "RecipeShare account yet? Please <a href="{{ route('signUp') }}">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

</html>