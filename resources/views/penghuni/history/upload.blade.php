<div class="modal fade" id="uploadModal{{ $history['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                <button type="button" onclick="resetFile('{{ $history['id'] }}')" id="btn-close" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/penghuni/history/{{ $history['id'] }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="wrap-upload">
                        <img id="icon-input-file-{{ $history['id'] }}" class="icon-input-file"
                            src="{{ asset('assets/uploadPict.svg') }}">
                        <input id="upload-file-{{ $history['id'] }}" type="file" name="photo" class="upload-file"
                            required onchange="loadFile('{{ $history['id'] }}')">
                        <input type="hidden" name="type" value="{{ $history['type'] }}">
                        <div class="preview" id="preview-{{ $history['id'] }}">
                            <div class="wrap-photo">
                                <img id="preview-photo-{{ $history['id'] }}" class="preview-photo">
                                <img class="cross" src="{{ asset('assets/silang.svg') }}" onclick="exit('{{$history['id']}}')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-submit" id="btn-modal-submit">Selesai</button>
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
