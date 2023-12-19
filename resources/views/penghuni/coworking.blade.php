@include('components.sidebaruser')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/coworking.css')
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
        <div class="bottom-box">
            <div class="schedule-box">
                @include('components.date')                
                <hr>
                <form action="/penghuni/coworking" method="post">
                    @csrf
                    <div class="wrap-validate-choose-date">
                        @if(!Request::get('date'))
                        <div class="wrap-span">
                            <span class="validate-choose-date">Choose Date</span>
                        </div>
                        @else
                        <h4>Pilih Jam Booking</h4>
                        <div class="wrap-time">

                            <div class="from-time">
                                <h5>Dari :</h5>
                                <select name="from-time" id="" class="from-time-select" required>
                                    @for($i = 6; $i <= 23; $i++)
                                    <option value="{{$i}}">{{$i . '.00'}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="to-time">
                                <h5>Sampai :</h5>
                                <select name="to-time" id="" class="to-time-select" required>
                                    @for($i = 7; $i <= 24; $i++)
                                    <option value="{{$i}}">{{$i . '.00'}}</option>
                                    @endfor
                                </select>
                            </div>
                            
                        </div>
                        <h4>Jumlah Partisipan</h4>
                        <div class="wrap-participation">
                            <input type="text" name="count" placeholder="Type Here" required>
                        </div>
                        <h4>Tipe</h4>
                        <div class="wrap-type">
                            <div class="wrap-private">
                                <input type="radio" name="book-type" value="Private" required>
                                <p>Private</p>
                            </div>
                            <div class="wrap-public">
                                <input type="radio" name="book-type" value="Public" required>
                                <p>Public</p>
                            </div>
                        </div>
                        <div class="wrap-submit">
                            <button type="submit">Submit</button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="today-user-box">
                Pengguna Hari Ini
            </div>
        </div>
    </div>
</body>
</html>