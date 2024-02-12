<div class="modal fade" id="deleteModal{{$user->NIP}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/dashboard/penghuni/{{$user->NIP}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE') --}}
                <input type="hidden" id="userId" value="{{$user->NIP}}">
                <div class="modal-body">
                    <p>Are you sure you want to delete <span>{{$user->name}}</span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan deletebtn" data-userid="{{$user->NIP}}">Delete</button>
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>

