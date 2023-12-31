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

                                <h2>Please choose the date first!</h2>

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

                                        @foreach ($FemaleMachine as $MM)

                                            <label>

                                                <input type="radio" name="machine" id="machine"
                                                    value="{{ $MM['machine_id'] }}" class="radio"
                                                    {{empty(Request::get('time')) || $MM['booked'] ? 'disabled' : ''}}>
                                                <span class="custom-radio mr">{{$MM['index']}}</span>

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

                <h3>Mesin Cuci</h3>

            </div>

        </div>

    </div>

    <script>
        function timeChange() {
            let queryString = window.location.search; // get url parameters
            let params = new URLSearchParams(queryString); // create url search params object
            params.delete("time"); // delete city parameter if it exists, in case you change the dropdown more then once
            params.append("time", document.getElementById("time").value); // add selected city
            document.location.href = "?" + params.toString(); // refresh the page with new url
        }

        // function stuffChange() {
        //     let queryString = window.location.search; // get url parameters
        //     let params = new URLSearchParams(queryString); // create url search params object
        //     let selectedStuff = document.querySelector('input[name="getStuff"]:checked');
        //     if (selectedStuff) {
        //         params.delete('stuff');
        //         params.append('stuff', selectedStuff.value);
        //         document.location.href = "?" + params.toString();
        //     }
        // }
    </script>

</body>

</html>
