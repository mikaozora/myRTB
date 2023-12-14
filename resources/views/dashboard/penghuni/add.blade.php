<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penghuni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/dashboard/penghuni" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="wrap-input">
                        <p>NIP</p>
                        <input type="text" name="NIP" required placeholder="xxxx">
                    </div>
                    <div class="wrap-input">
                        <p>Nama</p>
                        <input type="text" name="name" required placeholder="John Doe">
                    </div>
                    <div class="wrap-input">
                        <p>Gender</p>
                        <select name="gender" id="gender" class="form-select" aria-label="Default select example">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Male">Pria</option>
                            <option value="Female">Wanita</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Kelas</p>
                        <input type="text" name="class" required placeholder="PPTI 20">
                    </div>
                    <div class="wrap-input">
                        <p>No Kamar</p>
                        <input type="text" name="room_number" required placeholder="Axxx">
                    </div>
                    <div class="wrap-input">
                        <p>No Telepon</p>
                        <input type="text" name="phone_number" required placeholder="08xxx">
                    </div>
                    <div class="wrap-input">
                        <p>Foto Profile</p>
                        <input type="file" id="photo" name="photo" required accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
