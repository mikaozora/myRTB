<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/notification.css')
</head>

<body>
    <h3 class="notification {{ session('status') == 'error' ? 'error' : '' }}" id="notif">
        {{ session('message') }}
    </h3>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myDiv = document.getElementById("notif");
            // Show the div
            myDiv.style.visibility = "visible";
            myDiv.style.opacity = "1";
            setTimeout(function() {
                myDiv.classList.add("show-animate");
            }, 50);

            // Hide the div after 1 second
            setTimeout(function() {
                myDiv.style.visibility = "hidden";
                myDiv.style.opacity = "0";
            }, 3000); // 1000 milliseconds = 1 second
        });
    </script>
</body>

</html>
