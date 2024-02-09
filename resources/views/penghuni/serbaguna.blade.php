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
    @include('components.loader')
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
                        <div class="wrap-time">
                            <div class="from-time">
                                <h5>Dari :</h5>
                                <select name="from-time" id="fromtime" class="from-time-select" onchange="timeChange()" required>
                                    <option value="PilihJam">Pilih Jam</option>
                                    @foreach ($sergunAvail as $sa)
                                    <option value="{{$sa['value']}}" {{ Request::get('fromtime') == $sa['value']  ? 'selected' : '' }} {{$sa['booked'] == true ? 'disabled' : ''}} {{$sa['isAvailable'] == true ? '' : 'disabled'}}>
                                        {{$sa['label']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="to-time">
                                <h5>Sampai :</h5>
                                <select name="to-time" id="totime" class="to-time-select" required>
                                    <option value="">Pilih Jam</option>
                                    @foreach ($timeTo as $tt)
                                    <option value="{{ $tt['allval'] }}" {{ Request::get('totime') == $tt['value'] ? 'selected' : '' }} {{$tt['booked'] == true ? 'disabled' : ''}}>
                                        {{ $tt['label'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4>Pilih Area Serbaguna</h4>
                        <div class="wrap-sergun">
                            <div class="sergun">
                                @foreach ($sergunAvailLeft as $sl)
                                <label>
                                    <input type="radio" name="sergun" id="sergun" value="{{ $sl['room_id'] }}" class="radio" {{ empty(Request::get('fromtime')) || $sl['booked'] ? 'disabled' : '' }}>
                                    <span class="custom-radio mr">{{ $sl['index'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="wrap-submit">
                            <button id="submit-button" type="submit">Submit</button>
                        </div>

                        @endif
                    </div>
                </form>
            </div>

            <div class="wrap-right">
            <div class="sergun-content">
                    <h5>Area Serbaguna</h5>
                    <div class="sergun-items">
                        @foreach ($rooms as $room)
                            <label>
                                <input type="radio" name="getSergun" id="{{ $room['room_id'] }}"
                                    value="{{ $room['room_id'] }}" class="radio" onchange="sergunChange()"
                                    {{ Request::get('sergun') == $room['room_id'] ? 'checked' : '' }}>
                                <span class="custom-radio mr ml-0">{{ $loop->iteration }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="user-content">
                <h5>Pengguna Hari Ini</h5>
                <div class="wrap-scrollable">
                    @if (empty($books))
                        <p class="empty">Tidak ada pengguna hari ini</p>
                    @else
                        @foreach ($books as $book)
                            <div class="wrap-detail-user">
                                <img src="{{ asset('data/' . $book['photo']) }}" alt="">
                                <div class="wrap-detail-mid">
                                    <h6>{{ $book['name'] }}</h6>
                                    <p>{{ $book['class'] }}</p>
                                </div>
                                <div class="wrap-detail-right">
                                    <p>{{ $book['start_time'] }} - {{ $book['end_time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function timeChange() {
            let queryString = window.location.search; // get url parameters
            let params = new URLSearchParams(queryString); // create url search params object
            params.delete("fromtime"); // delete city parameter if it exists, in case you change the dropdown more then once
            params.append("fromtime", document.getElementById("fromtime").value); // add selected city
            document.location.href = "?" + params.toString(); // refresh the page with new url
        }

        function sergunChange() {
            let queryString = window.location.search; // get url parameters
            let params = new URLSearchParams(queryString); // create url search params object
            let selectedSergun = document.querySelector('input[name="getSergun"]:checked');
            if (selectedSergun) {
                params.delete('sergun');
                params.append('sergun', selectedSergun.value);
                document.location.href = "?" + params.toString();
            }
        }
    </script>

</body>

</html>