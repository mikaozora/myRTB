<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite('resources/css/content.css')
    @vite('resources/css/forum.css')
</head>
<body>    
    <!-- <div id="session-data" data-nip="{{ session('NIP') }}"></div> -->

    @include('components.sidebaradmin')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div id="messages" class="bottom-box">
                @php 
                    $prevDate = null;
                @endphp
                @foreach ($chats as $chat)

                    @php 
                        $currDate = \Carbon\Carbon::parse($chat->created_at)->format('Y-m-d'); 
                    @endphp

                    @if($currDate != $prevDate)
                        <h1>{{ \Carbon\Carbon::parse($chat->created_at)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}</h1>
                        @php
                            $prevDate = $currDate;
                        @endphp
                    @endif
                    
                    @if(session('NIP')!=$chat->NIP)
                    <!-- left chat -->
                    <div class="left-chat">
                        <div class="profile-info">
                            <img class="profile-pict" src="{{asset('data/' . $chat->photo)}}">
                            <h2>{{ $chat->name }}</h2>
                        </div>

                        <div class="container-chat">
                            <p>{{$chat->message}}</p>
                        </div>
                        <div class="time">
                            {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        </div>
                    </div>     
                    @else
                    <!-- right chat -->
                    <div class="right-chat">
                        <div class="time2">
                            {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        </div>
                        <div class="container-chat2">
                        <!-- <p>hello wasap this is  aslsalj ljnl aaaaaar</p>     -->
                        <p>{{$chat->message}}</p>
                        </div>
                    </div> 
                    @endif
                @endforeach

                <h1>{{$datenow}}</h1>

        </div>

        <form id="message_form" method="POST">
            @csrf
            <div class="inputs">
                <input id="message_input" type="text" name="message" placeholder="Ketik disini..">
                <!-- <input id="input-file" type="file" id="photo" name="photo" required accept=".png, .jpg, .jpeg" >             -->
                <!-- <img id="icon-input-file" src="{{asset('assets/uploadPict.svg')}}"> -->
                
                <button type="submit" id="message_send">Kirim</button>
            </div>
        </form>
    </div>

    <script>
        var laravelSessionData = @json(session()->all());
    </script>
    @vite("resources/js/forum.js")
</body>
</html>