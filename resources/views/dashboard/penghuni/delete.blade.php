<div class="modal fade" id="deleteModal{{$user->NIP}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Penghuni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/dashboard/penghuni/{{$user->NIP}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus <span>{{$user->name}}</span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
