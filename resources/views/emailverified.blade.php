<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
    <link href="{{ asset('assets/css/emailverified.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @include('components.navigationBar')
    @include('components.backgroundwave')
    @include('components.default')
    <title>Diodav</title>
</head>

<body>
    <div class="animate__animated animate__backInDown main-container">
        <div class="container-content">
            <img class="animate__animated animate__bounce animate__infinite"
                src="{{ asset('assets/img/thumbs up.png') }}">
            <h1>Account verified successfully</h1>
        </div>
        <div class="links">
            <a href="/login"><button class="btn-login">Go to login</button></a>
            <a href="/register"><button class="btn-register">Go to register</button></a>
        </div>
    </div>
</body>

</html>