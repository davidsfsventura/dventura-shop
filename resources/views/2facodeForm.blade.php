<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
    <link href="{{ asset('assets/css/2facode.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @include('components.navbar')
    @include('components.backgroundwave')
    @include('components.default')

    <title>Diodav</title>
</head>

<body>
    <div class="animate__animated animate__backInDown main-container">
        <div class="container-content">
            <img class="animate__animated animate__bounce animate__infinite"
                src="{{ asset('assets/img/2facode.png') }}">
            <h1>2 Factor Authenticator</h1>
            <p>Check your email for the security code</p>
            <form id="codeForm" name="codeForm" action="/users/authenticate/verify2facode" method="POST">
                @csrf
                <input name="code" maxlength="7" type="text" required>
                <button style="background: none; border:none;" type="submit">
                    <i id="continue" onmouseover="this.className = 'fa-solid fa-unlock fa-xl imouseover'"
                        onmouseout="this.className='fa-solid fa-lock fa-xl imouseout'"
                        style="color: #ea4646;--fa-animation-duration: 2s;--fa-animation-delay:1s;--fa-animation-iteration-count:4"
                        class="fa-solid fa-lock fa-xl"></i>
                </button>
                <a href="/users/send2fa" style="color: inherit;">
                    <h4>Resend Code</h4>
                </a>
            </form>
        </div>
        <div class="links">
            <a href="/login"><button class="btn-login">Go to login</button></a>
            <a href="/register"><button class="btn-register">Go to register</button></a>
        </div>
    </div>
    @error('codeerror')
    <script>
        document.getElementById("continue").classList.add('fa-shake');
    </script>
    @enderror
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
    <link href="{{ asset('assets/css/2facode.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @include('components.navbar')
    @include('components.backgroundwave')
    @include('components.default')

    <title>Diodav</title>
</head>

<body>
    <div class="animate__animated animate__backInDown main-container">
        <div class="container-content">
            <img class="animate__animated animate__bounce animate__infinite"
                src="{{ asset('assets/img/2facode.png') }}">
            <h1>2 Factor Authenticator</h1>
            <p>Check your email for the security code</p>
            <form id="codeForm" name="codeForm" action="/users/authenticate/verify2facode" method="POST">
                @csrf
                <input name="code" maxlength="7" type="text" required>
                <button style="background: none; border:none;" type="submit">
                    <i id="continue" onmouseover="this.className = 'fa-solid fa-unlock fa-xl imouseover'"
                        onmouseout="this.className='fa-solid fa-lock fa-xl imouseout'"
                        style="color: #ea4646;--fa-animation-duration: 2s;--fa-animation-delay:1s;--fa-animation-iteration-count:4"
                        class="fa-solid fa-lock fa-xl"></i>
                </button>
                <a href="/users/send2fa" style="color: inherit;">
                    <h4>Resend Code</h4>
                </a>
            </form>
        </div>
        <div class="links">
            <a href="/login"><button class="btn-login">Go to login</button></a>
            <a href="/register"><button class="btn-register">Go to register</button></a>
        </div>
    </div>
    @error('codeerror')
    <script>
        document.getElementById("continue").classList.add('fa-shake');
    </script>
    @enderror
</body>

</html>