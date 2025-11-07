<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="{{ asset('./includes/css/signInAndSignUp.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <div class="container-signIn">
        <form>
            <div class="signUp-box" div data-aos="fade-up">
                <!-- USERNAME -->
                <div class="imageLogo">
                    <img src="{{asset('includes/images/logo4.png')}}" alt="" width="400px">
                </div>

                <div class="username-box">
                    <p>USERNAME</p>
                    <input type="text" name="username" id="username" required placeholder="username / e-mail"
                        class="input-signUp">
                </div>
                <!-- PASSWORD -->
                <div class="password-box">
                    <p>PASSWORD</p>
                    <input type="password" name="password" id="password" required placeholder="password"
                        class="input-signUp">
                </div>
                <!-- BUTTON -->
                <div class="button-sign">
                    <button type="submit" class="bt-signUp">REGISTER</button>
                    <p> Back to <a href="{{ route('signIn') }}">Sign In</a></p>
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