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
    @vite('resources/css/view admin/viewdapur.css')
</head>
<body>
    @include('components.sidebaradmin')

    <div class="kontainer-header">

        @include('components.headercontent')

    </div>

    <div class="container-content">
        <div class="inner-box">
            <div class="wrap-tab">
                <a href="/dashboard/dapur?status=pemesanan"
                    class="{{ Request::get('status') == 'pemesanan' || !Request::get('status') ? 'active' : '' }}">Pemesanan</a>
                <a href="/dashboard/dapur?status=proses"
                    class="{{ Request::get('status') == 'proses' ? 'active' : '' }}">Proses</a>
                <a href="/dashboard/dapur?status=selesai"
                    class="{{ Request::get('status') == 'selesai' ? 'active' : '' }}">Selesai</a>
            </div>

            <hr>

            <div class='view'>

                @foreach ($dapur as $dapur)
                    <div class="view-list">
                        {{-- masing-masing booking --}}
                        <div class="list-detail">

                            <div class="booking-detail">

                                <h5> {{ $dapur['user_name'] }} </h5>
                                <p>{{ $dapur['stuff_name'] }}</p>
                                <p>{{ $dapur['date'] }}</p>
                                <p>{{ $dapur['desc'] }}</p>

                            </div>

                        </div>

                        <div class='info-button'>

                            @if ($dapur['status'] == 'Done')

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detail-{{$dapur['id']}}">i</button>

                            @endif

                            {{-- button information kalau di selesai --}}
                            @include('dashboard.ListDetail.bookdapurDetail')

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
