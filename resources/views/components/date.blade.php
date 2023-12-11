<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/date.css')
</head>
<body>
    <div class="wrap-date {{ Request::get('date') ? 'date-active' : '' }}">
        @if(!Request::get('date'))
        <span class="validate-choose-date">Choose Date</span>
        @endif
        @foreach($datenow as $date)
        <a href="/penghuni/coworking/?date={{$date}}" class="book-date {{Request::get('date') == $date ? 'active' : ''}}">{{$date}} 
        </a> 
        @endforeach
    </div>
</body>
</html>