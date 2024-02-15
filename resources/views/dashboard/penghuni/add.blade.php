<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
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
                        <p>Name</p>
                        <input type="text" name="name" required placeholder="John Doe">
                    </div>
                    <div class="wrap-input">
                        <p>Gender</p>
                        <select name="gender" id="gender" class="form-select" aria-label="Default select example">
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Class</p>
                        <select name="class" id="class" class="form-select" aria-label="Default select example">
                            <option value="">Select class</option>
                            <option value="PPBP 3">PPBP 3</option>
                            <option value="PPBP 4">PPBP 4</option>
                            <option value="PPBP 5">PPBP 5</option>
                            <option value="PPBP 6">PPBP 6</option>
                            <option value="PPTI 14">PPTI 14</option>
                            <option value="PPTI 15">PPTI 15</option>
                            <option value="PPTI 16">PPTI 16</option>
                            <option value="PPTI 17">PPTI 17</option>
                            <option value="PPTI 18">PPTI 18</option>
                            <option value="PPTI 19">PPTI 19</option>
                        </select>
                    </div>
                    <div class="wrap-input">
                        <p>Room Number</p>
                        <input type="text" name="room_number" required placeholder="Axxx" class="input-room">
                        <div class="error-room-first">
                            <label for="">Must starts with 'A' or 'B'</label>
                        </div>
                        <div class="error-room-second">
                            <label for="">Must followed by: G/1/2/3/5</label>
                        </div>
                        <div class="error-room-last">
                            <label for="">Must contains number between 01 - 32</label>
                        </div>
                    </div>
                    <div class="wrap-input">
                        <p>Phone Number</p>
                        <input type="text" name="phone_number" class="input-phone" required placeholder="08xxx">
                        <div class="error-phone-start">
                            <label for="">Phone Number must starts with '08'</label>
                        </div>
                        <div class="error-phone-length">
                            <label for="">Phone Number must be between 11 - 13 numbers</label>
                        </div>
                    </div>
                    <div class="wrap-input">
                        <p>Profile Photo</p>
                        <input type="file" id="photo" name="photo" required accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-simpan">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {

        var roomNumberInput = document.querySelector('.input-room');
        var errorRoomFirstDiv = document.querySelector('.error-room-first');
        var errorRoomSecondDiv = document.querySelector('.error-room-second');
        var errorRoomLastDiv = document.querySelector('.error-room-last');
        var phoneNumberInput = document.querySelector('.input-phone');
        var errorPhoneStartDiv = document.querySelector('.error-phone-start');
        var errorPhoneLengthDiv = document.querySelector('.error-phone-length');
        var submitButton = document.querySelector('button.btn-simpan');
        
        function setLabelColor(label, isValid) {
            label.style.color = isValid ? 'green' : 'red';
        }
        
        function isNumeric(value) {
            return /^\d+$/.test(value);
        }
        
        setLabelColor(errorRoomFirstDiv.querySelector('label'), false);
        setLabelColor(errorRoomSecondDiv.querySelector('label'), false);
        setLabelColor(errorRoomLastDiv.querySelector('label'), false);
        setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
        setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);
        
        function validateRoomNumber() {
            var roomNumberValue = roomNumberInput.value.toUpperCase();
            var valid = true;

            if (roomNumberValue.length !== 4){
                valid = false;
            }

            if (roomNumberValue[0] !== 'A' && roomNumberValue[0] !== 'B') {
                errorRoomFirstDiv.style.display = 'block';
                setLabelColor(errorRoomFirstDiv.querySelector('label'), false);
                valid = false;
            } else {
                setLabelColor(errorRoomFirstDiv.querySelector('label'), true);
        
                if (!['G', '1', '2', '3', '5'].includes(roomNumberValue[1])) {
                    errorRoomSecondDiv.style.display = 'block';
                    setLabelColor(errorRoomSecondDiv.querySelector('label'), false);
                    valid = false;
                } else {
                    setLabelColor(errorRoomSecondDiv.querySelector('label'), true);
                    
                    var thirdFourthDigits = roomNumberValue.substring(2);
                    
                    if (!isNumeric(thirdFourthDigits) || parseInt(thirdFourthDigits) < 1 || parseInt(thirdFourthDigits) > 32) {
                        errorRoomLastDiv.style.display = 'block';
                        setLabelColor(errorRoomLastDiv.querySelector('label'), false);
                        valid = false;
                    } else {
                        setLabelColor(errorRoomLastDiv.querySelector('label'), true);
                    }
                }
            }

            if (roomNumberValue.length !== 4){
                setLabelColor(errorRoomLastDiv.querySelector('label'), false);
                valid = false;
            }

            return valid;
        }

        function validatePhoneNumber() {
            var phoneNumberValue = phoneNumberInput.value;

            if (!isNumeric(phoneNumberValue)) {
                errorPhoneStartDiv.style.visible = 'visible';
                setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                return false;
            } else {
                errorPhoneStartDiv.style.visible = 'hidden';
                setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                if (!phoneNumberValue.startsWith('08')) {
                    errorPhoneStartDiv.style.visible = 'visible';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                    return false;
                } else {
                    errorPhoneStartDiv.style.visible = 'hidden';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                    if (phoneNumberValue.length < 11 || phoneNumberValue.length > 13) {
                        errorPhoneLengthDiv.style.visible = 'visible';
                        setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);
                        return false;
                    } else {
                        errorPhoneLengthDiv.style.visible = 'hidden';
                        setLabelColor(errorPhoneLengthDiv.querySelector('label'), true);
                        return true;
                    }
                }
            }
        }

        function allLabelsGreen() {
            var errorLabels = document.querySelectorAll('.error-label');
            for (var i = 0; i < errorLabels.length; i++) {
                if (errorLabels[i].style.color === 'red') {
                    return false;
                }
            }
            return true;
        }

        roomNumberInput.addEventListener('input', function () {
            var roomValid = validateRoomNumber();
            var phoneValid = validatePhoneNumber();
            submitButton.disabled = !(roomValid && phoneValid && allLabelsGreen());
        });

        phoneNumberInput.addEventListener('input', function () {
            var roomValid = validateRoomNumber();
            var phoneValid = validatePhoneNumber();
            submitButton.disabled = !(roomValid && phoneValid && allLabelsGreen());
        });

    });
</script> --}}