<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/resetcode.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('assets/img/main_logo.png') }}">
    <title>Diodav</title>
    @include('components.navbar')
    @include('components.backgroundwave')
    @include('components.default')
</head>

<body>
    <div class="main-container">
        <div class="container-content">
            <h1>Request a secret code change</h1>
            <div class="marginleft">
                <div class="formContent">
                    <form action="/users/resetcode" method="post">
                        @csrf
                        <div class="form__group field">
                            <input type="email" class="form__field" placeholder="Email" name="email" id="email"
                                value="{{ old('email') }}" required />
                            @error('resetcodeerror')
                            <p style="width: 25rem; position: absolute; color: #ea4646">{{ $message }}</p>
                            @enderror
                            <label for="name" class="form__label">Email</label>
                        </div>
                        <button class="btn-continue">Continue</button>
                    </form>
                </div>
            </div>
            <div class="links">
                <a href="/login" class="loginlink">Go back to login</a><br>
                <a href="/register" class="registerlink">Don't have an account?</a>
            </div>
        </div>
    </div>
</body>

</html>