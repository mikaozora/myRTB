<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    @vite('resources/css/content.css')
    @vite('resources/css/history.css')
</head>

<body>
    @include('components.sidebaruser')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div class="wrap-content">
            <div class="wrap-tab">
                <a href="/penghuni/history?status=pemesanan"
                    class="{{ Request::get('status') == 'pemesanan' || !Request::get('status') ? 'active' : '' }}">Pemesanan</a>
                <a href="/penghuni/history?status=proses"
                    class="{{ Request::get('status') == 'proses' ? 'active' : '' }}">Proses</a>
                <a href="/penghuni/history?status=selesai"
                    class="{{ Request::get('status') == 'selesai' ? 'active' : '' }}">Selesai</a>
            </div>
            <hr>
            <div class="wrapped">
                @foreach ($histories as $history)
                    <div class="wrapped-content">
                        <div class="history-detail">
                            <div class="content-detail">
                                <h5 style="font-weight: 600">{{ $history['title'] }}</h5>
                                <p>{{ $history['label'] }}</p>
                                <p>{{ $history['date'] }}</p>
                                <p>{{ $history['desc'] }}</p>
                            </div>
                        </div>
                        <div class="wrap-submit">
                            @if (Request::get('status') == 'proses')
                                <button type="button" class="btn-submit" id="btn-submit" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal{{ $history['id'] }}">Selesai</button>
                            @endif
                        </div>
                    </div>
                    @include('penghuni.history.upload')
                @endforeach
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    
</body>

</html>
