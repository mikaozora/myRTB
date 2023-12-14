<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{ $title }}</title>
    @vite('resources/css/content.css')
    @vite('resources/css/penghuni.css')
</head>

<body>
    @if(session('message'))
        @include('components.notification')
    @endif
    @include('components.sidebaradmin')
    @include('dashboard.penghuni.add')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div class="wrap-button">
            <button class="btn-penghuni" type="button" data-bs-toggle="modal" data-bs-target="#addModal"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 17 17" fill="none">
                    <path
                        d="M9.83317 1.9165C9.83317 1.58498 9.70147 1.26704 9.46705 1.03262C9.23263 0.7982 8.91469 0.666504 8.58317 0.666504C8.25165 0.666504 7.93371 0.7982 7.69929 1.03262C7.46487 1.26704 7.33317 1.58498 7.33317 1.9165V7.33317H1.9165C1.58498 7.33317 1.26704 7.46487 1.03262 7.69929C0.7982 7.93371 0.666504 8.25165 0.666504 8.58317C0.666504 8.91469 0.7982 9.23263 1.03262 9.46705C1.26704 9.70147 1.58498 9.83317 1.9165 9.83317H7.33317V15.2498C7.33317 15.5814 7.46487 15.8993 7.69929 16.1337C7.93371 16.3681 8.25165 16.4998 8.58317 16.4998C8.91469 16.4998 9.23263 16.3681 9.46705 16.1337C9.70147 15.8993 9.83317 15.5814 9.83317 15.2498V9.83317H15.2498C15.5814 9.83317 15.8993 9.70147 16.1337 9.46705C16.3681 9.23263 16.4998 8.91469 16.4998 8.58317C16.4998 8.25165 16.3681 7.93371 16.1337 7.69929C15.8993 7.46487 15.5814 7.33317 15.2498 7.33317H9.83317V1.9165Z"
                        fill="white" />
                </svg>
                Tambah Penghuni</button>
        </div>
        <div class="wrap-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Kamar</th>
                        <th scope="col">Kelas</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->NIP }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->gender == "Male" ? "Pria" : "Wanita" }}</td>
                            <td>{{ $user->room_number }}</td>
                            <td>{{ $user->class }}</td>
                            <td>
                                <div class="wrap-action">
                                    <button class="btn-action" data-bs-toggle="modal" data-bs-target="#editModal{{$user->NIP}}"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="20" viewBox="0 0 17 17" fill="none">
                                            <path
                                                d="M14.6696 4.98648C14.9458 4.71023 14.9458 4.24982 14.6696 3.98773L13.0121 2.33023C12.75 2.05398 12.2896 2.05398 12.0133 2.33023L10.71 3.62648L13.3663 6.28273M2.125 12.2186V14.8748H4.78125L12.6154 7.03357L9.95917 4.37732L2.125 12.2186Z"
                                                fill="#205295" />
                                        </svg></button>
                                    <button class="btn-action" type="button" data-bs-toggle="modal" data-bs-target="#detailModal{{$user->NIP}}"><svg xmlns="http://www.w3.org/2000/svg" width="25"
                                            height="25" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M12 10C11.7348 10 11.4804 10.1054 11.2929 10.2929C11.1054 10.4804 11 10.7348 11 11V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8946 17.5196 13 17.2652 13 17V11C13 10.7348 12.8946 10.4804 12.7071 10.2929C12.5196 10.1054 12.2652 10 12 10ZM12 6C11.7528 6 11.5111 6.07331 11.3055 6.21066C11.1 6.34801 10.9398 6.54324 10.8452 6.77165C10.7505 7.00005 10.7258 7.25139 10.774 7.49386C10.8223 7.73634 10.9413 7.95907 11.1161 8.13388C11.2909 8.3087 11.5137 8.42775 11.7561 8.47598C11.9986 8.52421 12.2499 8.49946 12.4784 8.40485C12.7068 8.31024 12.902 8.15002 13.0393 7.94446C13.1767 7.7389 13.25 7.49723 13.25 7.25C13.25 6.91848 13.1183 6.60054 12.8839 6.36612C12.6495 6.1317 12.3315 6 12 6Z"
                                                fill="#205295" />
                                        </svg></button>
                                    <button class="btn-action" id="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->NIP}}"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" viewBox="0 0 15 15" fill="none">
                                            <path
                                                d="M3.75 11.875C3.75 12.5625 4.3125 13.125 5 13.125H10C10.6875 13.125 11.25 12.5625 11.25 11.875V4.375H3.75V11.875ZM11.875 2.5H9.6875L9.0625 1.875H5.9375L5.3125 2.5H3.125V3.75H11.875V2.5Z"
                                                fill="#952020" />
                                        </svg></button>

                                </div>
                            </td>
                        </tr>
                        @include('dashboard.penghuni.detail')
                        @include('dashboard.penghuni.delete')
                        @include('dashboard.penghuni.edit')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
