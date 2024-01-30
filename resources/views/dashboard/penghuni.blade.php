<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <title>{{ $title }}</title>
    @vite('resources/css/content.css')
    @vite('resources/css/penghuni.css')
</head>

<body>
    @if (session('message'))
        @include('components.notification')
    @endif
    @include('components.sidebaradmin')
    @include('dashboard.penghuni.add')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div class="wrap-button">
            <input type="text" placeholder="Search..." class="input-search" id="search" autocomplete="off">
            <button class="btn-penghuni" type="button" data-bs-toggle="modal" data-bs-target="#addModal"><svg
                    xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 17 17" fill="none">
                    <path
                        d="M9.83317 1.9165C9.83317 1.58498 9.70147 1.26704 9.46705 1.03262C9.23263 0.7982 8.91469 0.666504 8.58317 0.666504C8.25165 0.666504 7.93371 0.7982 7.69929 1.03262C7.46487 1.26704 7.33317 1.58498 7.33317 1.9165V7.33317H1.9165C1.58498 7.33317 1.26704 7.46487 1.03262 7.69929C0.7982 7.93371 0.666504 8.25165 0.666504 8.58317C0.666504 8.91469 0.7982 9.23263 1.03262 9.46705C1.26704 9.70147 1.58498 9.83317 1.9165 9.83317H7.33317V15.2498C7.33317 15.5814 7.46487 15.8993 7.69929 16.1337C7.93371 16.3681 8.25165 16.4998 8.58317 16.4998C8.91469 16.4998 9.23263 16.3681 9.46705 16.1337C9.70147 15.8993 9.83317 15.5814 9.83317 15.2498V9.83317H15.2498C15.5814 9.83317 15.8993 9.70147 16.1337 9.46705C16.3681 9.23263 16.4998 8.91469 16.4998 8.58317C16.4998 8.25165 16.3681 7.93371 16.1337 7.69929C15.8993 7.46487 15.5814 7.33317 15.2498 7.33317H9.83317V1.9165Z"
                        fill="white" />
                </svg>
                Tambah Penghuni
            </button>
        </div>
        <div class="wrap-table">
            {{-- @include('dashboard.penghuni.pagination') --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        //pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1]
            let query = $('#search').val(); // Get the search query
            users(page, query);
        })

        function users(page, query) {
            $.ajax({
                url: "/dashboard/pagination/paginate-data",
                method: 'GET',
                data: {
                    page: page,
                    query: query
                },
                success: function(data) {
                    $('.wrap-table').html(data);
                }
            })
        }

        // search
        $(document).ready(function() {
            fetchData();

            function fetchData(query = '') {
                $.ajax({
                    url: "{{ route('search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'html',
                    success: function(data) {
                        $('.wrap-table').html(data);
                    }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val()
                fetchData(query)
            })
        })
    </script>

    <script>
        function buttonClicked(){
            function validatePhoneNumber(id) {
            var inputElement = document.getElementById('input-' + id);
            var errorStart = inputElement.parentElement.querySelector('.error-phone-start-edit label');
            var errorLength = inputElement.parentElement.querySelector('.error-phone-length-edit label');
            var phoneNumber = inputElement.value;

            if (/^08/.test(phoneNumber)) {
                errorStart.style.color = 'green';
            } else {
                errorStart.style.color = 'red';
            }

            if (/^\d{11,13}$/.test(phoneNumber)) {
                errorLength.style.color = 'green';
            } else {
                errorLength.style.color = 'red';
            }

            var submitButton = inputElement.closest('.modal-content').querySelector('.btn-simpan-edit');
            if (errorStart.style.color === 'red' || errorLength.style.color === 'red') {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }

        var phoneInputs = document.querySelectorAll('.input-phone-edit');
        phoneInputs.forEach(function(input) {
            var nip = input.id.split('-')[1];

            input.addEventListener('input', function() {
                validatePhoneNumber(nip);
            });

            validatePhoneNumber(nip);
        });
        }
    </script>
</body>

</html>
