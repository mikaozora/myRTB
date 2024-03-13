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
                        <select name="class" id="class" class="form-select" aria-label="Default select example">
                            <option value="">Select Room</option>
                            <option value="AG01">AG01</option>
                            <option value="AG02">AG02</option>
                            <option value="AG03">AG03</option>
                            <option value="AG04">AG04</option>
                            <option value="AG05">AG05</option>
                            <option value="AG06">AG06</option>
                            <option value="AG07">AG07</option>
                            <option value="AG08">AG08</option>
                            <option value="AG09">AG09</option>
                            <option value="AG10">AG10</option>
                            <option value="AG11">AG11</option>
                            <option value="AG12">AG12</option>
                            <option value="AG13">AG13</option>
                            <option value="AG14">AG14</option>
                            <option value="AG15">AG15</option>
                            <option value="AG16">AG16</option>
                            <option value="AG17">AG17</option>
                            <option value="AG18">AG18</option>
                            <option value="AG19">AG19</option>
                            <option value="AG20">AG20</option>
                            <option value="AG21">AG21</option>
                            <option value="AG22">AG22</option>
                            <option value="AG23">AG23</option>
                            <option value="AG24">AG24</option>
                            <option value="AG25">AG25</option>
                            <option value="AG26">AG26</option>
                            <option value="AG27">AG27</option>
                            <option value="AG28">AG28</option>
                            <option value="AG29">AG29</option>
                            <option value="AG30">AG30</option>
                            <option value="AG31">AG31</option>
                            <option value="AG32">AG32</option>

                            <option value="A101">A101</option>
                            <option value="A102">A102</option>
                            <option value="A103">A103</option>
                            <option value="A104">A104</option>
                            <option value="A105">A105</option>
                            <option value="A106">A106</option>
                            <option value="A107">A107</option>
                            <option value="A108">A108</option>
                            <option value="A109">A109</option>
                            <option value="A110">A110</option>
                            <option value="A111">A111</option>
                            <option value="A112">A112</option>
                            <option value="A113">A113</option>
                            <option value="A114">A114</option>
                            <option value="A115">A115</option>
                            <option value="A116">A116</option>
                            <option value="A117">A117</option>
                            <option value="A118">A118</option>
                            <option value="A119">A119</option>
                            <option value="A120">A120</option>
                            <option value="A121">A121</option>
                            <option value="A122">A122</option>
                            <option value="A123">A123</option>
                            <option value="A124">A124</option>
                            <option value="A125">A125</option>
                            <option value="A126">A126</option>
                            <option value="A127">A127</option>
                            <option value="A128">A128</option>
                            <option value="A129">A129</option>
                            <option value="A130">A130</option>
                            <option value="A131">A131</option>
                            <option value="A132">A132</option>

                            <option value="B101">B101</option>
                            <option value="B102">B102</option>
                            <option value="B103">B103</option>
                            <option value="B104">B104</option>
                            <option value="B105">B105</option>
                            <option value="B106">B106</option>
                            <option value="B107">B107</option>
                            <option value="B108">B108</option>
                            <option value="B109">B109</option>
                            <option value="B110">B110</option>
                            <option value="B111">B111</option>
                            <option value="B112">B112</option>
                            <option value="B113">B113</option>
                            <option value="B114">B114</option>
                            <option value="B115">B115</option>
                            <option value="B116">B116</option>
                            <option value="B117">B117</option>
                            <option value="B118">B118</option>
                            <option value="B119">B119</option>
                            <option value="B120">B120</option>
                            <option value="B121">B121</option>
                            <option value="B122">B122</option>
                            <option value="B123">B123</option>
                            <option value="B124">B124</option>
                            <option value="B125">B125</option>
                            <option value="B126">B126</option>
                            <option value="B127">B127</option>
                            <option value="B128">B128</option>
                            <option value="B129">B129</option>
                            <option value="B130">B130</option>
                            <option value="B131">B131</option>
                            <option value="B132">B132</option>

                            <option value="A201">A201</option>
                            <option value="A202">A202</option>
                            <option value="A203">A203</option>
                            <option value="A204">A204</option>
                            <option value="A205">A205</option>
                            <option value="A206">A206</option>
                            <option value="A207">A207</option>
                            <option value="A208">A208</option>
                            <option value="A209">A209</option>
                            <option value="A210">A210</option>
                            <option value="A211">A211</option>
                            <option value="A212">A212</option>
                            <option value="A213">A213</option>
                            <option value="A214">A214</option>
                            <option value="A215">A215</option>
                            <option value="A216">A216</option>
                            <option value="A217">A217</option>
                            <option value="A218">A218</option>
                            <option value="A219">A219</option>
                            <option value="A220">A220</option>
                            <option value="A221">A221</option>
                            <option value="A222">A222</option>
                            <option value="A223">A223</option>
                            <option value="A224">A224</option>
                            <option value="A225">A225</option>
                            <option value="A226">A226</option>
                            <option value="A227">A227</option>
                            <option value="A228">A228</option>
                            <option value="A229">A229</option>
                            <option value="A230">A230</option>
                            <option value="A231">A231</option>
                            <option value="A232">A232</option>

                            <option value="B201">B201</option>
                            <option value="B202">B202</option>
                            <option value="B203">B203</option>
                            <option value="B204">B204</option>
                            <option value="B205">B105</option>
                            <option value="B206">B206</option>
                            <option value="B207">B207</option>
                            <option value="B208">B208</option>
                            <option value="B209">B209</option>
                            <option value="B210">B210</option>
                            <option value="B211">B211</option>
                            <option value="B212">B212</option>
                            <option value="B213">B213</option>
                            <option value="B214">B214</option>
                            <option value="B215">B215</option>
                            <option value="B216">B216</option>
                            <option value="B217">B217</option>
                            <option value="B218">B218</option>
                            <option value="B219">B219</option>
                            <option value="B220">B220</option>
                            <option value="B221">B221</option>
                            <option value="B222">B222</option>
                            <option value="B223">B223</option>
                            <option value="B224">B224</option>
                            <option value="B225">B225</option>
                            <option value="B226">B226</option>
                            <option value="B227">B227</option>
                            <option value="B228">B128</option>
                            <option value="B229">B129</option>
                            <option value="B230">B130</option>
                            <option value="B231">B131</option>
                            <option value="B232">B132</option>

                            <option value="A301">A301</option>
                            <option value="A302">A302</option>
                            <option value="A303">A303</option>
                            <option value="A304">A304</option>
                            <option value="A305">A305</option>
                            <option value="A306">A306</option>
                            <option value="A307">A307</option>
                            <option value="A308">A308</option>
                            <option value="A309">A309</option>
                            <option value="A310">A310</option>
                            <option value="A311">A311</option>
                            <option value="A312">A312</option>
                            <option value="A313">A313</option>
                            <option value="A314">A314</option>
                            <option value="A315">A315</option>
                            <option value="A316">A316</option>
                            <option value="A317">A317</option>
                            <option value="A318">A318</option>
                            <option value="A319">A319</option>
                            <option value="A320">A320</option>
                            <option value="A321">A321</option>
                            <option value="A322">A322</option>
                            <option value="A323">A323</option>
                            <option value="A324">A324</option>
                            <option value="A325">A325</option>
                            <option value="A326">A326</option>
                            <option value="A327">A137</option>
                            <option value="A328">A328</option>
                            <option value="A329">A329</option>
                            <option value="A330">A330</option>
                            <option value="A331">A331</option>
                            <option value="A332">A332</option>

                            <option value="B301">B301</option>
                            <option value="B302">B302</option>
                            <option value="B303">B303</option>
                            <option value="B304">B304</option>
                            <option value="B305">B305</option>
                            <option value="B306">B306</option>
                            <option value="B307">B307</option>
                            <option value="B308">B308</option>
                            <option value="B309">B309</option>
                            <option value="B310">B310</option>
                            <option value="B311">B311</option>
                            <option value="B312">B312</option>
                            <option value="B313">B313</option>
                            <option value="B314">B314</option>
                            <option value="B315">B315</option>
                            <option value="B316">B316</option>
                            <option value="B317">B317</option>
                            <option value="B318">B318</option>
                            <option value="B319">B319</option>
                            <option value="B320">B320</option>
                            <option value="B321">B321</option>
                            <option value="B322">B322</option>
                            <option value="B323">B323</option>
                            <option value="B324">B324</option>
                            <option value="B325">B325</option>
                            <option value="B326">B326</option>
                            <option value="B327">B327</option>
                            <option value="B328">B328</option>
                            <option value="B329">B329</option>
                            <option value="B330">B330</option>
                            <option value="B331">B331</option>
                            <option value="B332">B332</option>

                            <option value="B501">B501</option>
                            <option value="B502">B502</option>
                            <option value="B503">B503</option>
                            <option value="B504">B504</option>
                            <option value="B505">5305</option>
                            <option value="B506">B506</option>
                            <option value="B507">B507</option>
                            <option value="B508">B508</option>
                            <option value="B509">B509</option>
                            <option value="B510">B510</option>
                            <option value="B511">B511</option>
                            <option value="B512">B512</option>
                            <option value="B513">B513</option>
                            <option value="B514">B514</option>
                            <option value="B515">B515</option>
                            <option value="B516">B516</option>
                            <option value="B517">B517</option>
                            <option value="B518">B518</option>
                            <option value="B519">B519</option>
                            <option value="B520">B520</option>
                            <option value="B521">B521</option>
                            <option value="B522">B522</option>
                            <option value="B523">B523</option>
                            <option value="B524">B524</option>
                            <option value="B525">B525</option>
                            <option value="B526">B526</option>
                            <option value="B527">B527</option>
                            <option value="B528">B528</option>
                            <option value="B529">B529</option>
                            <option value="B530">B530</option>
                            <option value="B531">B531</option>
                            <option value="B532">B532</option>
                        </select>
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
