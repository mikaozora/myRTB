<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite('resources/css/app.css')
    @vite('resources/css/content.css')
    @vite('resources/css/report.css')
    @include('components.favicon')
</head>
<body>
    @if(session('message'))
    @include('components.notification')
    @endif
    @include('components.sidebaruser')
    @include('components.loader')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <form action="/penghuni/report" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrap-all">
                <div class="wrap-type">
                    <h3>Type</h3>
                    <div class="wrap-allfasum">
                        <div class="wrap-fasum">
                            <input type="radio" name="report_type" value="Public Facility" required>
                            <p>Public Facility</p>
                        </div>
                        <div class="wrap-fasum">
                            <input type="radio" name="report_type" value="Room" required>
                            <p>Cluster/Room</p>
                        </div>
                    </div>
                </div>
                <div class="wrap-report">
                    <h3>Reports / Complaints</h3>
                    <textarea name="report" id="" cols="100" rows="15" placeholder="Please explain..." class="report-textarea" required></textarea>
                </div>
                <div class="wrap-photo-upload">
                    <h3>Upload Photo</h3>
                    <div class="wrap-photo">
                        <input name="photo" type="file" accept="image/jpg, image/png, image/jpeg" class="input-photo" required>
                    </div>
                </div>
                <div class="wrap-submit">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>