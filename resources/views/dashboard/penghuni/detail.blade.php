<div class="modal fade" id="detailModal{{$user->NIP}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="dialog-detail">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Penghuni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detail">
                <div class="wrap-detail">
                    <img class="photo" src="{{asset('data/' . $user->photo)}}" alt="photo">
                    <div class="detail-penghuni">
                        <div class="content">
                            <h6>NIP</h6>
                            <p>{{$user->NIP}}</p>
                        </div>
                        <div class="content">
                            <h6>Kamar</h6>
                            <p>{{$user->room_number}}</p>
                        </div>
                        <div class="content">
                            <h6>Nama</h6>
                            <p>{{$user->name}}</p>
                        </div>
                        <div class="content">
                            <h6>No Telepon</h6>
                            <p>{{$user->phone_number}}</p>
                        </div>
                        <div class="content">
                            <h6>Kelas</h6>
                            <p>{{$user->class}}</p>
                        </div>
                        <div class="content">
                            <h6>Jenis Kelamin</h6>
                            <p>{{$user->gender}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
