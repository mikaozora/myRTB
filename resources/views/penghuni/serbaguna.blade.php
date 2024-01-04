<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/sergun.css')
    @vite('resources/css/content.css')
    <title>{{$title}}</title>
</head>

<body>
    @if(session('message'))
    @include('components.notification')
    @endif
    @include('components.sidebaruser')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>

    <div class="container-content">
        <div class="wrap-content">
            <div class="wrap-left">
                @include('components.date')
                <hr>
                <form action="/penghuni/serbaguna?date={{ Request::get('date')}}" method="post">
                    @csrf
                    <div class="wrap-validate-choose-date">
                        @if(!Request::get('date'))
                        <div class="wrap-span">
                            <img src="{{ asset('/assets/ill-calendar.svg') }}" alt="">
                            <h6>Pilih tanggal dulu yuk</h6>
                        </div>
                        @else
                        <h4>Pilih Jam Booking</h4>

                        @endif
                    </div>
</div>

</body>
</html>