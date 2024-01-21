<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Diodav</title>
    @include('components.navbar')
    @include('components.backgroundwave')
    @include('components.default')
</head>

<body>
    <div class="main-container">
        <h1 class="header">About this project</h1>
        <div class="devInfo">
            <img src="{{ asset('assets/img/me.jpeg') }}" class="me_img">
            <div class="dev inline">
                <h2>Developer</h2>
                <h4 style="font-weight: normal">David Ventura</h4>
                <h4 style="font-weight: normal">19 years old</h4>
                <h4 style="font-weight: normal">Portuguese</h4>
                <a href="https://github.com/davidsfsventura/dventura-shop" target="_blank"><i
                        class="fa-brands fa-github fa-2xl icon"></i></a>
                <a href="/feedback" style="margin-left: 10px"><i class="fa-regular fa-envelope fa-2xl icon"></i></a>
            </div>
        </div>
        <div class="projectInfo">
            <p>
            <h3>Project Info</h3>
            Made using <a style="color:inherit" href="https://laravel.com/" target="_blank">
                Laravel PHP Framework</a>,
            this project is intended to have a bit of everything
            in order to widen my skill set and learn new things.<br><br>
            <h3>Project still in development</h3>
            </p>
        </div>
    </div>
</body>

</html>