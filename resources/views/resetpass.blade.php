<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diodav</title>
    <link href="{{ asset('assets/css/resetpass.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
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
            <h1>Enter your email</h1>
            <form action="/users/resetpass" method="post">
                @csrf
                <div class="email form__group field">
                    <input type="email" class="form__field" placeholder="Email" name="email" id="email"
                        value="{{old('email')}}" required />
                    <label for="name" class="form__label">Email</label>
                </div>
                <div class="pass form__group field">
                    <input type="password" class="form__field" placeholder="password" name="password" id="password"
                        value="{{old('password')}}" required />
                    <label for="name" class="form__label">New Password</label>
                </div>
                <div class="secretcode form__group field">
                    <input type="password" class="form__field" maxlength="7" placeholder="secretcode" name="secretcode"
                        id="secretcode" required />
                    @error('secretcode')
                    <p class="error">{{$message}}</p>
                    @enderror
                    <label for="name" class="form__label">Secret Code</label>
                    <div class="switchdiv">
                        <label class="switch">
                            <input type="checkbox" name="check" id="check" />
                            <span class="slider round"></span>
                        </label>
                        <span class="ssi-label">Are you sure?</span>
                        <a href=""><button class="btn-continue">Continue</button></a>
                    </div>
                </div>
            </form>
            <div class="links">
                <a href="/resetcode" class="resetcodelink">Reset secret code</a>
                <a href="/login" class="loginlink">Go back to login</a><br>
                <a href="/register" class="registerlink">Don't have an account?</a>
            </div>
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