<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <title>{{ $title }}</title>
    @vite('resources/css/content.css')
    @vite('resources/css/penghuni.css')
    @include('components.favicon')
</head>

<body>
    <div id="content-container">

        @if (session('message'))
            @include('components.notification')
        @endif
        @include('components.sidebaradmin')
        @include('components.loader')
        @include('dashboard.penghuni.add')
        <div class="kontainer-header">
            @include('components.headercontent')
        </div>
        <div class="container-content">
            <div class="wrap-button">
                <input type="text" placeholder="Search..." class="input-search" id="search" autocomplete="off">
                <button class="btn-penghuni" type="button" onclick="resetModalBackdrop()" data-bs-toggle="modal"
                    data-bs-target="#addModal"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                        viewBox="0 0 17 17" fill="none">
                        <path
                            d="M9.83317 1.9165C9.83317 1.58498 9.70147 1.26704 9.46705 1.03262C9.23263 0.7982 8.91469 0.666504 8.58317 0.666504C8.25165 0.666504 7.93371 0.7982 7.69929 1.03262C7.46487 1.26704 7.33317 1.58498 7.33317 1.9165V7.33317H1.9165C1.58498 7.33317 1.26704 7.46487 1.03262 7.69929C0.7982 7.93371 0.666504 8.25165 0.666504 8.58317C0.666504 8.91469 0.7982 9.23263 1.03262 9.46705C1.26704 9.70147 1.58498 9.83317 1.9165 9.83317H7.33317V15.2498C7.33317 15.5814 7.46487 15.8993 7.69929 16.1337C7.93371 16.3681 8.25165 16.4998 8.58317 16.4998C8.91469 16.4998 9.23263 16.3681 9.46705 16.1337C9.70147 15.8993 9.83317 15.5814 9.83317 15.2498V9.83317H15.2498C15.5814 9.83317 15.8993 9.70147 16.1337 9.46705C16.3681 9.23263 16.4998 8.91469 16.4998 8.58317C16.4998 8.25165 16.3681 7.93371 16.1337 7.69929C15.8993 7.46487 15.5814 7.33317 15.2498 7.33317H9.83317V1.9165Z"
                            fill="white" />
                    </svg>
                    Add User
                </button>
            </div>
            <div class="wrap-table">
                {{-- @include('dashboard.penghuni.pagination') --}}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        //pagination
        $(document).ready(function() {
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
                    dataType: 'html',
                    success: function(data) {
                        $('.wrap-table').html(data);
                    }
                })
            }
        })

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


        // update
        // Function to handle visibility

        function handleVisibility() {
            return new Promise(function(resolve) {
                var myDiv = document.getElementById("notif");

                // Show the div if found
                if (myDiv) {
                    myDiv.style.visibility = "visible";
                    myDiv.style.opacity = "1";
                    setTimeout(function() {
                        myDiv.classList.add("show-animate");
                    }, 50);

                    // Hide the div after 1 second
                    setTimeout(function() {
                        myDiv.style.visibility = "hidden";
                        myDiv.style.opacity = "0";
                    }, 3000);
                } else {
                    console.error("Element with id 'notif' not found.");
                    resolve(); // Resolve the promise even if the element is not found
                }
            });
        }

        function showLoader() {
            return new Promise(function(resolve) {
                window.addEventListener('load', () => {
                    const loader = document.querySelector('.wrap-loader');
                    console.log(loader);

                    // Add loader-hidden class
                    console.log("hellow");
                    loader.classList.add('loader-hidden');
                    console.log(loader); // Check if loader has the loader-hidden class

                    // Resolve the promise after adding the class
                    resolve();
                })
            })
        }

        // Function to update HTML content
        function updateHTML(response) {
            return new Promise(function(resolve) {
                $('body').html(response);
                resolve();
            });
        }

        // Function to reattach keyup event
        function reattachKeyupEvent() {
            return new Promise(function(resolve) {
                $('#search').on('keyup', function() {
                    var query = $(this).val();
                    fetchData(query);
                });
                resolve();
            });
        }

        function attachToggleListener() {
            const toggle = document.querySelector('.img-container');
            const menu = document.querySelector('.logout');
            toggle.addEventListener('click', function() {
                menu.classList.toggle('show');

            });
        }
        document.body.addEventListener('click', function(event) {
            // Check if the clicked element has the class .img-container
            if (event.target.matches('.img-container')) {
                const menu = document.querySelector('.logout');
                menu.classList.toggle('show');
            }
        });

        // Main function to handle AJAX and subsequent actions
        $(document).ready(function() {
            $(document).ajaxComplete(function() {
                // Add loader-hidden class to .wrap-loader after successful AJAX request
                $('.wrap-loader').addClass('loader-hidden');
            });

            // Remove existing click event handlers
            $(document).off('click', '.editbtn');

            // Attach click event handler for .editbtn
            $(document).on('click', '.editbtn', function(e) {
                e.preventDefault();
                $(this).prop('disabled', true);

                // $('.modal-backdrop').remove();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let userId = $(this).data('userid');
                let nama = $(`#nama-${userId}`).val();
                let gender = $(`#gender-${userId}`).val();
                let kelas = $(`#class-${userId}`).val();
                let kamar = $(`#kamar-${userId}`).val();
                let telp = $(`#input-${userId}`).val();
                let photo = $(`#photo-${userId}`)[0].files[0];

                let formData = new FormData();
                formData.append('name', nama);
                formData.append('gender', gender);
                formData.append('class', kelas);
                formData.append('room_number', kamar);
                formData.append('phone_number', telp);
                formData.append('photo', photo);
                formData.append('_method', 'PUT');

                let modalId = `#editModal${userId}`;

                $.ajax({
                    url: "/dashboard/penghuni/" + userId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Use promises to sequence actions
                        updateHTML(response)
                            .then(reattachKeyupEvent)
                            .then(handleVisibility) // Call handleVisibility after HTML update
                            .then(function() {
                                $('.editbtn').prop('disabled', false);

                                // Reset the form fields
                                $(modalId + ' form')[0].reset();

                                // Reattach the toggle event listener
                                attachToggleListener()

                            })
                            .catch(function(error) {
                                console.error("Error:", error);
                            });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
            attachToggleListener();
            reAttachValidatePhone();
        });

        // delete
        $(document).ready(function() {
            $(document).ajaxComplete(function() {
                // Add loader-hidden class to .wrap-loader after successful AJAX request
                $('.wrap-loader').addClass('loader-hidden');
            });
            // Remove existing click event handlers
            $(document).off('click', '.deletebtn');

            $(document).on('click', '.deletebtn', function(e) {
                e.preventDefault();
                $(this).prop('disabled', true);

                // Get the CSRF token from the meta tag
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                let userId = $(this).data('userid');

                $.ajax({
                    url: "/dashboard/penghuni/" + userId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        // Use promises to sequence actions
                        updateHTML(response)
                            .then(reattachKeyupEvent)
                            .then(handleVisibility) // Call handleVisibility after HTML update
                            .then(function() {
                                $('.deletebtn').prop('disabled', false);

                                // Reset the form fields
                                attachToggleListener()
                            })
                            .catch(function(error) {
                                console.error("Error:", error);
                            });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        })
    </script>

    <script>
        function resetModalBackdrop() {
            $('.modal-backdrop.show:not(:first)').remove();
        }

        function buttonClicked() {
            $('.modal-backdrop.show:not(:first)').remove();
            $('.modal-backdrop.show:not(:first)').remove();

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
    <script>
        function reAttachValidatePhone() {
            var phoneNumberInput = document.querySelector('.input-phone');
            var errorPhoneStartDiv = document.querySelector('.error-phone-start');
            var errorPhoneLengthDiv = document.querySelector('.error-phone-length');
            var submitButton = document.querySelector('button.btn-simpan');

            function setLabelColor(label, isValid) {
                label.style.color = isValid ? 'green' : 'red';
            }

            function isNumeric(value) {
                return !isNaN(value);
            }

            errorPhoneStartDiv.style.visible = 'hidden';
            errorPhoneLengthDiv.style.visible = 'hidden';
            setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
            setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);

            phoneNumberInput.addEventListener('input', function() {
                var phoneNumberValue = phoneNumberInput.value;

                if (!isNumeric(phoneNumberValue)) {
                    errorPhoneStartDiv.style.visible = 'visible';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                    submitButton.disabled = true;
                } else {
                    errorPhoneStartDiv.style.visible = 'hidden';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                    if (!phoneNumberValue.startsWith('08')) {
                        errorPhoneStartDiv.style.visible = 'visible';
                        setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                        submitButton.disabled = true;
                    } else {
                        errorPhoneStartDiv.style.visible = 'hidden';
                        setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                        if (phoneNumberValue.length < 11 || phoneNumberValue.length > 13) {
                            errorPhoneLengthDiv.style.visible = 'visible';
                            setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);
                            submitButton.disabled = true;
                        } else {
                            errorPhoneLengthDiv.style.visible = 'hidden';
                            setLabelColor(errorPhoneLengthDiv.querySelector('label'), true);
                            submitButton.disabled = false;
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
