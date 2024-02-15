<div class="modal fade" id="editModal{{ $user->NIP }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/dashboard/penghuni/{{ $user->NIP }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="wrap-input">
                        <p>NIP</p>
                        <input type="text" name="NIP" required placeholder="xxxx" value="{{ $user->NIP }}"
                            disabled>
                    </div>
                    <div class="wrap-input">
                        <p>Name</p>
                        <input type="text" name="nama" required placeholder="John Doe"
                            value="{{ $user->name }}" id="nama-{{$user->NIP}}">
                    </div>
                    <div class="wrap-input">
                        <p>Gender</p>
                        <select name="gender" id="gender-{{$user->NIP}}" class="form-select" aria-label="Default select example">
                            <option value="">Select gender</option>
                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Class</p>
                        <select name="class" id="class-{{$user->NIP}}" class="form-select" aria-label="Default select example">
                            <option value="">Select class</option>
                            <option value="PPBP 3" {{ $user->class == 'PPBP 3' ? 'selected' : '' }}>PPBP 3</option>
                            <option value="PPBP 4" {{ $user->class == 'PPBP 4' ? 'selected' : '' }}>PPBP 4</option>
                            <option value="PPBP 5" {{ $user->class == 'PPBP 5' ? 'selected' : '' }}>PPBP 5</option>
                            <option value="PPBP 6" {{ $user->class == 'PPBP 6' ? 'selected' : '' }}>PPBP 6</option>
                            <option value="PPTI 14" {{ $user->class == 'PPTI 14' ? 'selected' : '' }}>PPTI 14</option>
                            <option value="PPTI 15" {{ $user->class == 'PPTI 15' ? 'selected' : '' }}>PPTI 15</option>
                            <option value="PPTI 16" {{ $user->class == 'PPTI 16' ? 'selected' : '' }}>PPTI 16</option>
                            <option value="PPTI 17" {{ $user->class == 'PPTI 17' ? 'selected' : '' }}>PPTI 17</option>
                            <option value="PPTI 18" {{ $user->class == 'PPTI 18' ? 'selected' : '' }}>PPTI 18</option>
                            <option value="PPTI 19" {{ $user->class == 'PPTI 19' ? 'selected' : '' }}>PPTI 19</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Room Number</p>
                        <input type="text" id="kamar-{{$user->NIP}}" name="room_number" required placeholder="Axxx"
                            value="{{ $user->room_number }}">
                    </div>
                    <div class="wrap-input">
                        <p>Phone Number</p>
                        <input type="text" id="input-{{ $user->NIP }}" name="phone_number"
                            class="input-phone-edit" required placeholder="08xxx" value="{{ $user->phone_number }}">
                        <div class="error-phone-start-edit">
                            <label for="">Phone Number must starts with '08'</label>
                        </div>
                        <div class="error-phone-length-edit">
                            <label for="">Phone Number must be between 11 - 13 numbers</label>
                        </div>
                    </div>
                    <div class="wrap-input">
                        <p>Profile Photo</p>
                        <input type="file" class="photo" id="photo-{{$user->NIP}}" name="photo" value="{{ $user->photo }}"
                            accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan-edit editbtn" data-userid="{{$user->NIP}}">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>