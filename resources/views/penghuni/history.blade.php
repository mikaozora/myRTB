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
    @if(session('message'))
        @include('components.notification')
    @endif
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
                                <div class="wrap-title">
                                    <h5 style="font-weight: 600">{{ $history['title'] }}</h5>
                                    @if ($history['isLate'] == '1')              
                                    <div title="Anda terkena hukuman" style="height: 20px; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 30 30" fill="none">
                                            <path d="M15 1.875C18.481 1.875 21.8194 3.25781 24.2808 5.71922C26.7422 8.18064 28.125 11.519 28.125 15C28.125 18.481 26.7422 21.8194 24.2808 24.2808C21.8194 26.7422 18.481 28.125 15 28.125C11.519 28.125 8.18064 26.7422 5.71922 24.2808C3.25781 21.8194 1.875 18.481 1.875 15C1.875 11.519 3.25781 8.18064 5.71922 5.71922C8.18064 3.25781 11.519 1.875 15 1.875ZM15 7.5C14.7619 7.4998 14.5265 7.54924 14.3086 7.64518C14.0908 7.74112 13.8953 7.88145 13.7347 8.05719C13.5742 8.23293 13.452 8.44023 13.3761 8.66585C13.3001 8.89146 13.2721 9.13044 13.2938 9.3675L13.9781 16.8787C14.0047 17.1313 14.1238 17.365 14.3125 17.535C14.5012 17.7049 14.7461 17.7989 15 17.7989C15.2539 17.7989 15.4988 17.7049 15.6875 17.535C15.8762 17.365 15.9953 17.1313 16.0219 16.8787L16.7044 9.3675C16.726 9.13059 16.698 8.89178 16.6222 8.66629C16.5464 8.4408 16.4244 8.23359 16.264 8.05788C16.1037 7.88217 15.9084 7.74181 15.6908 7.64575C15.4732 7.5497 15.2379 7.50006 15 7.5ZM15 22.5C15.3978 22.5 15.7794 22.342 16.0607 22.0607C16.342 21.7794 16.5 21.3978 16.5 21C16.5 20.6022 16.342 20.2206 16.0607 19.9393C15.7794 19.658 15.3978 19.5 15 19.5C14.6022 19.5 14.2206 19.658 13.9393 19.9393C13.658 20.2206 13.5 20.6022 13.5 21C13.5 21.3978 13.658 21.7794 13.9393 22.0607C14.2206 22.342 14.6022 22.5 15 22.5Z" fill="#952020"/>
                                          </svg>
                                    </div>
                                    @endif
                                </div>
                                <p>{{ $history['label'] }}</p>
                                <p>{{ $history['date'] }}</p>
                                <p>{{ $history['desc'] }}</p>
                            </div>
                        </div>
                        <div class="wrap-submit">
                            @if (Request::get('status') == 'proses' && $history['type'] != 'report')
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
