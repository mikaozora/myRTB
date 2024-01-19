<div class="modal fade" id="editModal{{$user->NIP}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Penghuni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/dashboard/penghuni/{{$user->NIP}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="wrap-input">
                        <p>NIP</p>
                        <input type="text" name="NIP" required placeholder="xxxx" value="{{$user->NIP}}" disabled>
                    </div>
                    <div class="wrap-input">
                        <p>Nama</p>
                        <input type="text" name="name" required placeholder="John Doe" value="{{$user->name}}">
                    </div>
                    <div class="wrap-input">
                        <p>Gender</p>
                        <select name="gender" id="gender" class="form-select" aria-label="Default select example">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Male" {{$user->gender == "Male" ? "selected" : ""}}>Pria</option>
                            <option value="Female" {{$user->gender == "Female" ? "selected" : ""}}>Wanita</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Kelas</p>
                        <input type="text" name="class" required placeholder="PPTI 20" value="{{$user->class}}">
                    </div>
                    <div class="wrap-input">
                        <p>No Kamar</p>
                        <input type="text" name="room_number" required placeholder="Axxx" value="{{$user->room_number}}">
                    </div>
                    <div class="wrap-input">
                        <p>No Telepon</p>
                        <input type="text" id="input-{{$user->NIP}}" name="phone_number" class="input-phone-edit" required placeholder="08xxx" value="{{$user->phone_number}}">
                        <div class="error-phone-start-edit">
                            <label for="">Phone Number must starts with '08'</label>
                        </div>
                        <div class="error-phone-length-edit">
                            <label for="">Phone Number must be between 11 - 13 numbers</label>
                        </div>
                    </div>
                    <div class="wrap-input">
                        <p>Foto Profile</p>
                        <input type="file" id="photo" name="photo" value="{{$user->photo}}" accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan-edit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>