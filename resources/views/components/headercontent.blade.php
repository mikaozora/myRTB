<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/header.css')
</head>

<body>
    <div class="wrap-header">
        <div class="container-header">
            <h3>{{ $title }}</h3>
            <div class="img-container">
            <img class="profile-pict" src="{{asset('data/' .$photoProfile)}}">

            </div>
        </div>
        <div class="logout">
            <button class="btn-popup">Edit Password</button>
            <form action="/logout" method="POST">
                @csrf
                <button class="btn-popup" type="submit">Logout</button>
            </form>
        </div>
    </div>

    @vite('resources/js/header.js')
</body>

</html>
