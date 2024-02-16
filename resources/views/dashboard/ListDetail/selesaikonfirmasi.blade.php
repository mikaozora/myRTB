<div class="modal fade" id="selesai-{{ $report['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                <button type="button" onclick="resetFile('{{ $report['id'] }}')" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/dashboard/report/{{$report['id']}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="wrap-upload">
                        <img id="icon-input-file-{{ $report['id'] }}" class="icon-input-file"
                            src="{{ asset('assets/uploadPict.svg') }}">
                        <input id="upload-file-{{ $report['id'] }}" type="file" name="photo" accept=".png, .jpg, .jpeg" class="upload-file"
                            required onchange="loadFile('{{ $report['id'] }}')">
                        {{-- <input type="hidden" name="type" value="{{ $report['type'] }}"> --}}

                        <div class="preview" id="preview-{{ $report['id'] }}">
                            <div class="wrap-photo">
                                <img id="preview-photo-{{ $report['id'] }}" class="preview-photo">
                                <img class="cross" src="{{ asset('assets/silang.svg') }}" onclick="exit('{{$report['id']}}')">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Done</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    var loadFile = function(id) {
        var content = document.getElementById('preview-' + id);
        content.style.display = 'block';
        var output = document.getElementById("preview-photo-" + id);
        output.src = URL.createObjectURL(event.target.files[0]);
        let icon = document.getElementById('icon-input-file-' + id);
        let inputFile = document.getElementById('upload-file-' + id);
        inputFile.style.display = 'none';
        icon.style.display = 'none';
    }

    var resetFile = (id) => {
        var output = document.getElementById("preview-photo-" + id);
        output.removeAttribute('src');
        let icon = document.getElementById('icon-input-file-' + id);
        let inputFile = document.getElementById('upload-file-' + id);
        inputFile.style.display = 'block';
        icon.style.display = 'block';
    }

    function exit(id) {
        let preview = document.getElementById("preview-" + id);
        preview.style.display = 'none';
        var output = document.getElementById("preview-photo-" + id);
        output.removeAttribute('src');
        let icon = document.getElementById('icon-input-file-' + id);
        let inputFile = document.getElementById('upload-file-' + id);
        inputFile.style.display = 'block';
        icon.style.display = 'block';

    }
</script>
