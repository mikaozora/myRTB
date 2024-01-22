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
    @include('components.sidebaradmin')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div class="content">
            <div id="messages" class="bottom-box" id="bottom-box">
                    @php 
                        $prevDate = null;
                    @endphp
                    @foreach ($chats as $chat)

                        @php 
                            $currDate = \Carbon\Carbon::parse($chat->created_at)->format('Y-m-d'); 
                        @endphp

                        @if($currDate != $prevDate)
                            <div class="datenow">
                                <h1>{{ \Carbon\Carbon::parse($chat->created_at)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}</h1>
                            </div>
                            @php
                                $prevDate = $currDate;
                            @endphp
                        @endif
                        
                        @if(session('NIP')!=$chat->NIP)
                        <!-- left chat -->
                        <div class="left-chat">
                            <div class="profile-info">
                                <img class="profile-pict" src="{{asset('data/' . $chat->photo)}}" onclick="exit2('showpp')">
                                <h2>{{ $chat->name }}</h2>
                                <div id="showpp">
                                    <img class="x" src="{{ asset('assets/silang.svg') }}" onclick="exit2('showpp')">
                                    <img id="pp" class="pp" src="{{asset('data/' . $chat->photo)}}">
                                </div>
                            </div>
                            <div class="wrap">
                                <div class="container-chat">
                                    @if($chat->type == "img")
                                        <img id="image_result" src=" {{asset('forum/'. $chat->message) }}" onclick="exit2('showimg')">
                                    @else
                                        <p>{{$chat->message}}</p>
                                    @endif
                                </div>
                                <div class="time">
                                    {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                                </div>
                            </div>
                        </div>     
                        @else
                        <!-- right chat -->
                        <div class="right-chat">
                            <div class="wrap2">
                                <div class="time2">
                                    {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                                </div>
                                <div class="container-chat2">
                                    @if($chat->type == "img")
                                        <img id="image_result" src=" {{asset('forum/'. $chat->message) }}" onclick="exit2('showimg')">
                                    @else
                                        <p>{{$chat->message}}</p>
                                    @endif                        
                                </div>
                            </div>
                        </div> 
                        @endif
                    @endforeach

                    <!-- <h1>{{$datenow}}</h1> -->
                    <div id="datenow"></div>
                        <div id="showimg">
                            <img class="x2" src="{{ asset('assets/silang.svg') }}" onclick="exit2('showimg')">
                            <img id="img" src=" {{asset('forum/'. $chat->message) }}">
                    </div>
                </div>
            </div>
        </div>

        <form id="message_form" method="POST" enctype="multipart/form-data" action="/penghuni/forum/send-msg">
            @csrf
            <div class="inputs">
                <input id="message_input" type="text" name="message" placeholder="Ketik disini..">
                <input id="file_input" type="file" name="photo" accept=".png, .jpg, .jpeg" onchange="loadFile(event)">            
                <img id="icon-input-file" src="{{asset('assets/uploadPict.svg')}}">
                  
                <div id="msg_wrap">
                    <img id="file_result">
                    <img class="cross" src="{{ asset('assets/silang.svg') }}" onclick="exit('msg_wrap')">
                </div>

                <button type="submit" id="message_send">Kirim</button>

            </div>
        </form>
    </div>
    <div id="last-chat" data-created-at="{{ $lastChat }}"></div>
    
    <script>
        var laravelSessionData = @json(session()->all());
        const lastCreatedAt = "{{ $lastChat }}";

        var loadFile = function (e) {
            var content = document.getElementById('msg_wrap');
            content.style.display = 'block';   
            var output = document.getElementById("file_result");
            output.src = URL.createObjectURL(event.target.files[0]); 
            message_input.setAttribute('disabled','true');
        }

        function exit(msg_wrap){
            var content = document.getElementById(msg_wrap);
            var fileInput = document.getElementById('file_input');
            if (content.style.display !== 'none') {
                content.style.display = 'none';
                fileInput.value = '';
            } else {
                content.style.display = 'block';
            }
            message_input.removeAttribute('disabled')
        }

        function exit2(show){
            var content = document.getElementById(show);
            var tempat = document.getElementsByClassName("bottom-box");
            if (content.style.display !== 'none') {
                content.style.display = 'none';
                tempat[0].classList='bottom-box';
            } else {
                content.style.display = 'block';
                tempat[0].classList=('bottom-box freeze');
            }
        }


    </script>
    @vite("resources/js/forum.js")
</body>
</html>