<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diodav</title>
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" type="text/css">
    <script>
        var showimg = '{{ URL::asset('assets/img/show.png') }}';
    var hideimg = '{{ URL::asset('assets/img/hide.png') }}';
    </script>
    @include('components.navigationBar')
    @include('components.backgroundwave')
    @include('components.default')
</head>

<body>

    @error('passwordreset')
    <div class="popup open-popup" id="popup">
        <img src="{{ asset('assets/img/thumbs up.png') }}" />
        <h2>Password Reset</h2>
        <p style="color: #47E038">{{ $message }}</p>
        <button type="button" class="popupbutton"
            onclick="document.getElementById('popup').classList.remove('open-popup');" style="margin-left: 1rem">
            Thanks
        </button>
    </div>
    @enderror
    @error('codereset')
    <div class="popup open-popup" id="popup">
        <img src="{{ asset('assets/img/thumbs up.png') }}" />
        <h2>Secret Code Reset</h2>
        <p style="color: #47E038"><strong>{{ $message }}</strong></p>
        <button type="button" class="popupbutton"
            onclick="document.getElementById('popup').classList.remove('open-popup');" style="margin-left: 1rem">
            Thanks
        </button>
    </div>
    @enderror

    @error('deleteaccount')
    <div class="popup open-popup" id="popup">
        <img src="{{ asset('assets/img/thumbs up.png') }}" />
        <h2>Account Deletion</h2>
        <p style="color: #47E038">{{ $message }}</p>
        <button type="button" class="popupbutton"
            onclick="document.getElementById('popup').classList.remove('open-popup');" style="margin-left: 1rem">
            Thanks
        </button>
    </div>
    @enderror

    <div class="main-container">
        <div class="marginleft">
            <h1>Enter your credentials</h1>
            <form action="/users/authenticate" method="post">
                @csrf
                <div class="email form__group field">
                    <input type="email" class="form__field" placeholder="Email" name="email" id="email"
                        value="{{old('email')}}" required />
                    <label for="name" class="form__label">Email</label>
                </div>

                <div class="pass form__group field">
                    <input type="password" class="form__field" placeholder="Password" name="password" id="password"
                        value="{{old('password')}}" required />
                    @error('password')
                    <p style="position: absolute; color:#ea4646">{{$message}}</p>
                    @enderror
                    <label for="name" class="form__label">Password</label>
                    <img id="passpic" class="img-pass" value="show" src="{{ asset('assets/img/show.png') }}"
                        onclick="PassChange()" />
                    <label class="switch">
                        <input type="checkbox" />
                        <span class="slider round"></span>
                    </label>
                    <span class="ssi-label">Stay signed in</span>
                    <a href=""><button class="btn-continue">Continue</button></a>
                </div>
            </form>
            <a href="/resetpassword" class="resetpass">Reset password</a><br>
            <a href="/register" class="registerlink">Don't have an account?</a>
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