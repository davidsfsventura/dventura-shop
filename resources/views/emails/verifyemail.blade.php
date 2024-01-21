<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Diodav</title>

    <style>
        .verifyBtn {
            background: white;
            border: 1px solid black;
            width: 100px;
            height: 30px;
            border-radius: 5px;
        }

        .verifyBtn:hover {
            cursor: pointer;
            background: gainsboro;
        }
    </style>
</head>

<body>
    <h1>{{ $verify['title'] }}</h1>
    <h3 style="display: inline;">{{ $verify['body'] }}</h3>
    <a href="{{ $verify['link'] }}"><button class="verifyBtn">Verify Email</button></a>
    <br><br>
    <img width="200px" src="https://i.gifer.com/7Uz.gif">
    <p>Thank You.</p>

</body>

</html>