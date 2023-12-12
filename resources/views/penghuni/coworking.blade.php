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
    @include('components.sidebaruser')
    <div class="container-content">
        @include('components.headercontent')
        <div class="bottom-box">
            <div class="schedule-box">
                @include('components.date')                
                <hr>
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
                        </div>
                        <div class="to-time">
                            <h5>Sampai :</h5>
                        </div>
                    </div>
                    <h4>Jumlah Partisipan</h4>
                    <div class="wrap-participation">
                        <input type="text" name="count" placeholder="Type Here">
                    </div>
                    <h4>Tipe</h4>
                    <div class="wrap-type">
                        <div class="wrap-private">
                            <input type="radio" name="private-radio">
                            <p>Private</p>
                        </div>
                        <div class="wrap-public">
                            <input type="radio" name="public-radio">
                            <p>Public</p>
                        </div>
                    </div>
                    <div class="wrap-submit">
                        <button type="submit">Submit</button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="today-user-box">
                Pengguna Hari Ini
            </div>
        </div>
    </div>
</body>
</html>