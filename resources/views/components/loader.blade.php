<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/loader.css')
</head>

<body>
    <div class="wrap-loader">
        <div class="custom-loader"></div>
    </div>
</body>

<script>
    window.addEventListener('load', () => {
        const loader = document.querySelector('.wrap-loader')
        console.log(loader);
        loader.classList.add('loader-hidden')

        loader.addEventListener('transitioned', () => {
            document.body.removeChild('loader')
        })
    })
</script>

</html>
