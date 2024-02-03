<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diodav</title>
    <link href="{{ asset('assets/css/register.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('assets/img/main_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <script>
        var showimg = '{{ URL::asset('assets/img/show.png') }}';
        var hideimg = '{{ URL::asset('assets/img/hide.png') }}';
    </script>
    <script src="{{ asset('assets/js/js.js') }}"></script>
    @include('components.navigationBar')
    @include('components.backgroundwave')
    @include('components.default')
</head>

<body>
    <div class="main-container">
        <div class="marginleft">
            <h1>Create an account <i
                    style="font-size: 2rem;--fa-animation-duration: 3s;--fa-animation-delay: 1.5s;--fa-animation-timing: ease-in-out;"
                    class="fa-regular fa-face-smile fa-bounce fa-lg"></i></h1>
            <form action="/users/register" method="post">
                @csrf
                <div class="user form__group field">
                    <input type="text" class="form__field" maxlength="12" placeholder="Username" name="username"
                        id="username" value="{{ old('username') }}" required>
                    <label for="username" class="form__label">Username</label>
                </div>
                <div class="email form__group field">
                    <input type="email" class="form__field" placeholder="Email" name="email" id="email"
                        value="{{ old('email') }}" required>
                    <label for="email" class="form__label">Email</label>
                </div>
                <div class="pass form__group field">
                    <input type="password" class="form__field" placeholder="Password" name="password" id="password"
                        value="{{ old('password') }}" required>
                    @error('password')
                    <p class="error">{{ $message }}</p>
                    @enderror
                    <label for="password" class="form__label">Password</label>
                    <img id="passpic" class="img-pass" value="show" src="{{ asset('assets/img/show.png') }}"
                        onclick="PassChange()">
                    <div class="switchdiv">
                        <label class="switch">
                            <input type="checkbox" name="check" id="check">
                            <span class="slider round"></span>
                        </label>
                        <span class="ssi-label">Terms and Conditions</span>
                    </div>
                    <a href=""><button class="btn-continue">Continue</button></a>
                </div>
            </form>
            <a href="/login" class="loginlink">Go back to login</a>
        </div>
    </div>
</body>
<script>
    function PassChange() {
        var fullPath = document.getElementById("passpic").src;
        var filename = fullPath.replace(/^.*[\\\/]/, "");
        if (filename === "show.png") {
            filename = hideimg;
            document.getElementById("passpic").src = filename;
            document.getElementById("password").type = "text";
        } else if (filename === "hide.png") {
            filename = showimg;
            document.getElementById("passpic").src = filename;
            document.getElementById("password").type = "password";
        }
    }
</script>

</html>