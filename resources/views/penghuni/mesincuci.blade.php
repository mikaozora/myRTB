<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite('resources/css/app.css')
    @vite('resources/css/content.css')
    @vite('resources/css/mesincuci.css')
</head>

<body>

    @if (session('message'))

        @include('components.notification')

    @endif

    @include('components.sidebaruser')

    <div class="kontainer-header">

        @include('components.headercontent')

    </div>

    <div class = "container-content">

        {{-- ini bagian inner box --}}
        <div class = "inner-box">

            {{-- ini untuk form schedule --}}
            <div class="schedule-box">

                @include('components.date')
                <hr>

                <form action="/penghuni/mesincuci?date={{ Request::get('date') }}" method="post">

                    @csrf

                    <div class="validate-date">

                        {{-- make sure users choose the date --}}
                        @if (!Request::get('date'))

                            <div class="Not-choose-date">

                                <img src="{{ asset('/assets/ill-calendar.svg') }}" alt="">
                                <h6>Please choose the date first!</h6>

                            </div>


                        @else

                            <h4>Pilih Jam Booking</h4>
                            <div class="Choose-time">


                                <div class='opt-time'>

                                    {{--drop down untuk milih waktu  --}}
                                    <select name="opt-time" id="time" class="from-time-select"
                                    onchange="timeChange()" required>

                                        {{-- tampilih kata pertama di drop down--}}
                                        <option value=""> Pilih Jam</option>

                                        {{-- pengulangan jam yang ada --}}
                                        {{-- timeavail minta dari controller --}}

                                        @foreach ($timeAvail as $time)
                                            <option value="{{ $time['value'] }}"  {{ Request::get('time') == $time['value'] ? 'selected' : '' }} {{$time['isAvailable'] ? '' : 'disabled'}}>
                                                {{ $time['label'] }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <h4>Pilih Mesin Cuci</h4>
                            <div class="Choose-Washing-Machine">

                                @if ($userGender == 'Male')

                                    <div class="Male-Washing-Machine">

                                        @foreach ($MaleMachine as $MM)

                                            <label>

                                                <input type="radio" name="machine" id="machine"
                                                    value="{{ $MM['machine_id'] }}" class="radio"
                                                    {{empty(Request::get('time')) || $MM['booked'] ? 'disabled' : ''}}>
                                                <span class="custom-radio mr">{{$MM['index']}}</span>

                                            </label>

                                        @endforeach

                                    </div>

                                @else
                                    {{-- <h5>female</h5> --}}

                                    <div class="Female-Washing-Machine">

                                        @foreach ($FemaleMachine as $FM)

                                            <label>

                                                <input type="radio" name="machine" id="machine"
                                                    value="{{ $FM['machine_id'] }}" class="radio"
                                                    {{empty(Request::get('time')) || $FM['booked'] ? 'disabled' : ''}}>
                                                <span class="custom-radio mr">{{$FM['index']}}</span>

                                            </label>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                            <button type="submit" class="btn-submit">Submit</button>
                        @endif

                    </div>

                </form>

            </div>

            {{-- ini untuk pengguna hari ini --}}
            <div class="today-user-box">

                <div class="Look-Washing-Machine">

                    <h4>Mesin Cuci</h4>

                    <div class="washing-machines">

                        @if ($userGender == 'Male')
                            @foreach ($MaleMachine as $MM)
                                <label>
                                    <input type="radio" name="getMachine" id="{{ $MM['machine_id']}}"
                                    value="{{ $MM['machine_id'] }}" class="radio" onchange="machineChange()"
                                    {{Request::get('machine') == $MM['machine_id'] ? 'checked' : ''}}>
                                    <span class="custom-radio mr ml-0">{{$loop->iteration}}</span>
                                </label>

                            @endforeach

                        @else
                            @foreach ($FemaleMachine as $FM)
                                <label>
                                    <input type="radio" name="getMachine" id="{{ $FM['machine_id']}}"
                                    value="{{ $FM['machine_id'] }}" class="radio" onchange="machineChange()"
                                    {{Request::get('machine') == $FM['machine_id'] ? 'checked' : ''}}>
                                    <span class="custom-radio mr ml-0">{{$loop->iteration}}</span>
                                </label>

                            @endforeach

                        @endif

                    </div>

                </div>

                <div class="Check-Users">

                    <h4>Pengguna Hari Ini</h4>

                    @if ($userGender == 'Male')

                        <div class="Users-Scrollable_M">

                            @if (empty($books_M))

                            <p class="empty">Tidak ada pengguna hari ini</p>

                        @else

                            @foreach ($books_M as $book)

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

                                    </div>

                                </div>

                            @endforeach

                        @endif
                        </div>

                    @else
                        <div class="Users-Scrollable_F">
                            {{-- ini bagian yang cewek kalau booking --}}
                            {{-- kalau kosong alias ga ada yang booking --}}
                            @if (empty($books_F))
                                <p class="empty">Tidak ada pengguna hari ini</p>

                            @else

                                @foreach ($books_F as $book)

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

                    @endif


                </div>

            </div>

        </div>

    </div>

    <script>
        function timeChange() {
            let queryString = window.location.search;
            let params = new URLSearchParams(queryString);
            params.delete("time");
            params.append("time", document.getElementById("time").value);
            document.location.href = "?" + params.toString();
        }

        function machineChange()
        {
            let queryString = window.location.search;
            let params = new URLSearchParams(queryString);
            let selectedMachine = document.querySelector('input[name="getMachine"]:checked');
            if(selectedMachine)
            {
                params.delete("machine");
                params.append("machine", selectedMachine.value);
                document.location.href = "?" + params.toString();
            }
        }
    </script>

</body>

</html>
