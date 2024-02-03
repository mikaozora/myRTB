<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/header.css')
</head>

<body>
    <div class="wrap-header">
        <div class="container-header">
            <h3>{{ $title }}</h3>
            <div class="img-container">
                <img class="profile-pict" src="{{ asset('data/' . $photoProfile) }}">

            </div>
        </div>
        <div class="logout">
            <!-- <button type="button" class="btn btn-popup" data-bs-toggle="modal" data-bs-target="#detail-{{ session('NIP') }}">Edit Password</button> -->

            <!-- <form action="/view-change-password" method="GET"> -->
            <!-- @csrf -->
            @if (session('NIP') !== '9999')
                <button class="btn-popup" onclick="openModal()">Edit Password</button>
            @endif
            <!-- </form> -->
            <!-- <a href="/view-change-password" class="btn-popup" onclick="openModal()">Edit Password</a> -->

            <form action="/logout" method="POST">
                @csrf
                <button class="btn-popup" type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="overlay_header" id="overlay_header"></div>

    <div id="detailnip{{ session('NIP') }}" class="contain">
        <img class="close" src="{{ asset('assets/silang.svg') }}" onclick="closeModal()">
        <h5>Change Password</h5>
        <form action="/change-password" method="POST">
            @csrf
            @method('PUT')
            <div class="wrapp">
                <label class="judul" for="oldPassword">Old Password</label>
                <input class="pass_input" type="password" id="oldPassword" name="oldPassword" class="oldPassword"
                    placeholder="Masukkan password lama" name="oldPassword" required oninput="verifyPassword()">
                <div id="pesan_error">

                </div>
            </div>
            <div class="wrapp">
                <label class="judul" for="newPassword">New Password</label>
                <input class="pass_input" type="password" id="newPassword" name="newPassword"
                    placeholder="Buat password baru" name="newPassword" minlength="8" required>
            </div>
            <div class="wrapp">
                <button id="submit" class="submit" type="submit">Save Changes</button>
            </div>
            <div id="currentPassword" data-password="{{ $currentPassword }}"></div>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @vite('resources/js/header.js')
    <script>
        // @if (isset($openn) && $openn === true)
        //     openModal();
        // @endif

        // @if (isset($error) && $error === 'wrong_old_password')
        //     document.getElementById("pesan_error").innerHTML = "Wrong old password";
        // @endif

        function openModal() {
            document.getElementById("detail-{{ session('NIP') }}").style.display = "block";
            document.getElementById("overlay_header").style.display = "block";
        }

        function closeModal() {
            document.getElementById("detail-{{ session('NIP') }}").style.display = "none";
            document.getElementById("overlay_header").style.display = "none";
        }
        // var currentPassword = document.getElementById('currentPassword').getAttribute('data-password');
        // var oldPassInput = document.getElementById('oldPassword');

        // document.addEventListener('DOMContentLoaded', function () {
        //     console.log(currentPassword);

        //     if (oldPassInput) {
        //         oldPassInput.addEventListener('input', function () {
        //             var enteredPassword = oldPassInput.value;
        //             console.log(enteredPassword);
        //             console.log(currentPassword);
        //             var hashedEnteredPassword = hashFunction(enteredPassword);
        //             if (hashedEnteredPassword !== currentPassword) {
        //                 console.log("enteredpass != curpass");
        // var pesanErrorDiv = document.getElementById("pesan_error");
        // pesanErrorDiv.innerHTML = "Wrong old password";
        // pesanErrorDiv.style.display = "block";
        //             }
        //         });
        //     }
        // });
        var submitButton = document.getElementById('submit');

        function verifyPassword() {
            var enteredPassword = document.getElementById('oldPassword').value;

            $.ajax({
                type: 'POST',
                url: '/verify-password', // Sesuaikan dengan URL endpoint Anda
                data: {
                    enteredPassword: enteredPassword,
                    _token: '{{ csrf_token() }}' // Tambahkan CSRF token
                },
                success: function(response) {
                    var enteredPasswordFromController = response.enteredPassword;
                    console.log(enteredPassword);
                    console.log('Entered Password from Controller:', enteredPasswordFromController);

                    if (response.status === 'success') {
                        // Password cocok, lakukan aksi selanjutnya
                        console.log('Password cocok');
                        var pesanErrorDiv = document.getElementById("pesan_error");
                        pesanErrorDiv.style.display = "none";
                        submitButton.style.opacity = 1;
                        submitButton.disabled = false;
                    } else {
                        var pesanErrorDiv = document.getElementById("pesan_error");
                        pesanErrorDiv.innerHTML = "Wrong old password";
                        pesanErrorDiv.style.display = "block";
                        submitButton.disabled = true;
                        submitButton.style.opacity = 0.5;
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>

</html>
