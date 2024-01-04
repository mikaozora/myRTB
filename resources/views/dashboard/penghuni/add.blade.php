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
                        <input type="text" name="phone_number" class="input-phone" required placeholder="08xxx">
                        <div class="error-phone-start">
                            <label for="">Phone Number must starts with '08'</label>
                        </div>
                        <div class="error-phone-length">
                            <label for="">Phone Number must be between 11 - 13 numbers</label>
                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var phoneNumberInput = document.querySelector('.input-phone');
        console.log(phoneNumberInput.value)
        var errorPhoneStartDiv = document.querySelector('.error-phone-start');
        var errorPhoneLengthDiv = document.querySelector('.error-phone-length');
        var submitButton = document.querySelector('button.btn-simpan');

        // Function to set label color
        function setLabelColor(label, isValid) {
            label.style.color = isValid ? 'green' : 'red';
        }

        // Function to check if input is a number
        function isNumeric(value) {
            return !isNaN(value);
        }

        // Hide error messages and set initial label color
        errorPhoneStartDiv.style.visible = 'hidden';
        errorPhoneLengthDiv.style.visible = 'hidden';
        setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
        setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);

        // Attach an event listener to the phone number input for the 'input' event
        phoneNumberInput.addEventListener('input', function () {
            var phoneNumberValue = phoneNumberInput.value;
            console.log(phoneNumberInput.value)

            // Check if the input is a number
            if (!isNumeric(phoneNumberValue)) {
                errorPhoneStartDiv.style.visible = 'visible';
                setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                submitButton.disabled = true;
            } else {
                errorPhoneStartDiv.style.visible = 'hidden';
                setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                // Check if the phone number starts with '08'
                if (!phoneNumberValue.startsWith('08')) {
                    errorPhoneStartDiv.style.visible = 'visible';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), false);
                    submitButton.disabled = true;
                } else {
                    errorPhoneStartDiv.style.visible = 'hidden';
                    setLabelColor(errorPhoneStartDiv.querySelector('label'), true);

                    // Check if the phone number length is between 11 and 13 numbers
                    if (phoneNumberValue.length < 11 || phoneNumberValue.length > 13) {
                        errorPhoneLengthDiv.style.visible = 'visible';
                        setLabelColor(errorPhoneLengthDiv.querySelector('label'), false);
                        submitButton.disabled = true;
                    } else {
                        errorPhoneLengthDiv.style.visible = 'hidden';
                        setLabelColor(errorPhoneLengthDiv.querySelector('label'), true);
                        submitButton.disabled = false;
                    }
                }
            }
        });
    });
</script>