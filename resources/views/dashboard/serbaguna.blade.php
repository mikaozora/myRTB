<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{$title}}</title>
    @vite('resources/css/content.css')
    @vite('resources/css/view admin/viewserbaguna.css')
    @include('components.favicon')
</head>
<body>
    @include('components.sidebaradmin')
    @include('components.loader')
    <div class="kontainer-header">

        @include('components.headercontent')

    </div>

    <div class="container-content">
        <div class="inner-box">
            <div class="wrap-tab">
                <a href="/dashboard/serbaguna?status=pemesanan"
                    class="{{ Request::get('status') == 'pemesanan' || !Request::get('status') ? 'active' : '' }}">Booked</a>
                <a href="/dashboard/serbaguna?status=proses"
                    class="{{ Request::get('status') == 'proses' ? 'active' : '' }}">Ongoing</a>
                <a href="/dashboard/serbaguna?status=selesai"
                    class="{{ Request::get('status') == 'selesai' ? 'active' : '' }}">Done</a>
            </div>

            <hr>

            <div class='view'>

                @foreach ($serbaguna as $serbaguna)
                    <div class="view-list">
                        {{-- masing-masing booking --}}
                        <div class="list-detail">

                            <div class="booking-detail">

                                <h5> {{ $serbaguna['user_name'] }} </h5>
                                <p>{{ $serbaguna['room_name'] }}</p>
                                <p>{{ $serbaguna['date'] }}</p>
                                <p>{{ $serbaguna['desc'] }}</p>

                            </div>

                        </div>

                        <div class='info-button'>

                            @if ($serbaguna['status'] == 'Done')

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detail-{{$serbaguna['id']}}">i</button>

                            @endif

                            {{-- button information kalau di selesai --}}
                            @include('dashboard.ListDetail.bookserbagunaDetail')

                        </div>



                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
</body>
</html>
