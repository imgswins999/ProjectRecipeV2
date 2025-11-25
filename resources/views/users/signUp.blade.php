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
            <div class="container">
                <form action="{{ route('signUpPost') }}" method="post">
                @csrf
            <div class="signUp-box" div data-aos="fade-up">
                <!-- USERNAME -->
                <div class="imageLogo">
                    <img src="{{asset('includes/images/logo4.png')}}" alt="" width="400px">
                </div>
                
                <div class="username-box">
                    <p>EMAIL</p>
                    <input type="email" name="email" id="email" placeholder="email"  class="input-signUp">
                    @error('email')
                     <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div>
                        @enderror

                    <p style="margin-top:20px;">USERNAME</p>
                    <input type="text" name="username" id="username"placeholder="username"
                        class="input-signUp">
                        @error('username')
                     <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                </div>
                    
                <!-- PASSWORD -->
                <div class="password-box">
                    <p>PASSWORD</p>
                    <input type="password" name="password" id="password"placeholder="password"
                        class="input-signUp">
                        @error('password')
                     <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    <p style="margin-top:20px">CONFIRM PASSWORD</p>
                    <input type="password" name="password_confirmation" id="password_confirmation"  class="input-signUp">
                </div>
                <!-- BUTTON -->
                <div class="button-sign">
                    <button type="submit" class="bt-signUp">REGISTER</button>
                    <p> Back to <a href="{{ route('signIn') }}">Sign In</a></p>
                </div>
                </div>
            </form>
        </div>
        </form>
    </div>
</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

</html>