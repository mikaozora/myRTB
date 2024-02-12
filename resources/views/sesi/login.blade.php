<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    @vite('resources/css/login.css')
    @include('components.favicon')
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Welcome to</h2>
            <h1>myRTB</h1>
            <div class="form">
                <form action="/sesi/login" method="POST">
                    @csrf
                    <div class="group">
                        <label>NIP</label><br>
                        <input type="text" name="NIP" class="input" placeholder="Masukkan NIP"><br>
                    </div>
                    <div class="group">
                        <label>Password</label><br>
                        <div class="password-container">
                            <input type="password" name="password" class="input pass" id ="password" placeholder="Masukkan Password">
                            <img id="eye" src="{{asset('assets/eyeoff.svg')}}">
                        </div>
                        @if(isset($error) && ($error == "NIP or Password is required" || $error == "Invalid NIP or Password"))
                            <label class="errormsg">{{$error}}</label>                    
                        @endif
                    </div>
                    <div class="group btn">
                        <button name="submit" type="submit" class="submitbtn">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        <img class="image" src="{{asset('assets/rtbLogin.svg')}}" alt="">
    
    </div>
    <script>
        let eye = document.getElementById("eye");
        let password = document.getElementById("password");
        eye.onclick = function(){
            if(password.type == "password"){
                password.type = "type";
                eye.src = "{{asset('assets/eyeon.svg')}}";
            }else{
                password.type = "password";
                eye.src = "{{asset('assets/eyeoff.svg')}}";
            }
        }
    </script>
</body>
</html>