import "./bootstrap";
import axios from "axios";
 
const messages_el = document.getElementById("messages");
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form");

const file_input = document.getElementById("file_input");

const currentPath = window.location.pathname; 

const nip = laravelSessionData.NIP;


// function scrollToBottom() {
//     messages_el.scrollTop = messages_el.scrollHeight;
// }
function scrollToBottom() {
    const extraScroll = messages_el.scrollHeight *99999999*999999999; 
    messages_el.scrollTop = messages_el.scrollHeight + extraScroll;
}


message_form.addEventListener("submit", function (e) {
    e.preventDefault();

    let has_errors = false;

    if (message_input.value === "" && file_input.value === "") {
        // alert("please enter message");
        has_errors = true;
    }

    if (has_errors) {
        return;
    }
    if (message_input.value === "") {
        message_input.value = file_input.value;
    } else if (file_input.value === "") {
    }
    const formData = new FormData();

    if(file_input.value){
        formData.append("photo", file_input.files[0] ,file_input.files[0].name);
    }else{
        formData.append("message", message_input.value);
    }

    const options = {
        method: "post",
        url: currentPath + "/send-msg",
        data: formData
    };

    axios(options).then(() => {
        scrollToBottom(); // Panggil scrollToBottom setelah pesan dikirim
    });
    
    // scrollToBottom();
});
let eventBefore = new Date();

window.Echo.channel('chat')
    .listen('.message', (e) => {

        //buat tanggal
        // const options = {
        //     weekday: "long",
        //     year: "numeric",
        //     month: "long",
        //     day: "numeric",
        // };

        const edate = new Date(e.created_at);
        const hours = edate.getHours().toString().padStart(2, "0");
        const minutes = edate.getMinutes().toString().padStart(2, "0");
        const timenow = hours + ":" + minutes;

        let date = "";
        let formattedDate = "";
        let formattedDate2 = "";

        let eventNow = edate;
        let temp = false;
        eventNow.setHours(0, 0, 0, 0);
        let eventNowDate = new Date(eventNow);
        if (lastCreatedAt === "null") {
            if (eventBefore.getTime() !== eventNowDate.getTime()) {
                temp = true;
            } else {
                temp = false;
            }
            date = edate;
        } else if (lastCreatedAt !== "null") {
            eventBefore.setHours(0, 0, 0, 0);
            date = new Date(lastCreatedAt);
            if (
                eventBefore.getTime() !== eventNowDate.getTime()
            ) {
                temp = true;
            } else {
                temp = false;
            }
        }
        // console.log("eventNow" + eventNow);
        // console.log("eventBefore" + eventBefore);

        // formattedDate = date.toLocaleDateString("en-US", options);

        // const eformattedDate = edate.toLocaleDateString("en-US", options);

        // Function to add ordinal suffix to the day
        // function addOrdinalSuffix(day) {
        //     if (day >= 11 && day <= 13) {
        //         return day + "th";
        //     } else {
        //         const lastDigit = day % 10;
        //         switch (lastDigit) {
        //             case 1:
        //                 return day + "st";
        //             case 2:
        //                 return day + "nd";
        //             case 3:
        //                 return day + "rd";
        //             default:
        //                 return day + "th";
        //         }
        //     }
        // }

        // formattedDate = date.toLocaleDateString("en-US", options);

        // const dayWithOrdinalSuffix = addOrdinalSuffix(date.getDate());
        // const eformattedDate = formattedDate.replace(
        //     date.getDate(),
        //     dayWithOrdinalSuffix
        // );

        // console.log(formattedDate);
        // console.log(eformattedDate);
        const options = {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric",
        };

        function formatDateToCustomString(datee) {
            const dayWithOrdinalSuffix = addOrdinalSuffix(datee.getDate());
            const eeformattedDate = datee.toLocaleDateString("en-US", options);
            const eformattedDate = eeformattedDate.replace(
                datee.getDate(),
                dayWithOrdinalSuffix
            );

            return eformattedDate + ", " + datee.getFullYear();
        }

        function addOrdinalSuffix(day) {
            if (day >= 11 && day <= 13) {
                return day + "th";
            } else {
                const lastDigit = day % 10;
                switch (lastDigit) {
                    case 1:
                        return day + "st";
                    case 2:
                        return day + "nd";
                    case 3:
                        return day + "rd";
                    default:
                        return day + "th";
                }
            }
        }
        // const dayWithOrdinalSuffix = addOrdinalSuffix(date.getDate());
        // eformattedDate = eformattedDate.replace(
        //     date.getDate(),
        //     dayWithOrdinalSuffix
        // );

        formattedDate = date.toLocaleDateString("en-US", options);

        const dayWithOrdinalSuffix = addOrdinalSuffix(date.getDate());
        const formattedDateTrue = formattedDate.replace(
            date.getDate(),
            dayWithOrdinalSuffix
        );
        // const edate = new Date(e.created_at);

        formattedDate2 = edate.toLocaleDateString("en-US", options);

        const dayWithOrdinalSuffix2 = addOrdinalSuffix(edate.getDate());
        const formattedDateTrue2 = formattedDate2.replace(
            edate.getDate(),
            dayWithOrdinalSuffix2
        );

            

        if (formattedDateTrue2 !== formattedDateTrue || temp) {
            datenow.innerHTML +=
                '<dic class="datenow"><h1>' +
                formattedDateTrue2 +
                "</h1></div>";
        }

        eventBefore = eventNowDate;

        // var index_el = document
        //     .getElementById("index")
        //     .getAttribute("index");
        // var index = parseInt(index_el, 10);
        // console.log(index_el);
        var index = new Date().getTime();
        var showimgg = "showimgg_" + index;

        if (e.type === "img") {
            if (nip == e.nip) {
                messages_el.innerHTML +=
                    '<div class="right-chat"><div class="wrap2"><div class="time2">' +
                    timenow +
                    '</div> <div class="container-chat2"><img id="image_result" src="../forum/' +
                    e.message +
                    '" onclick="exit2(\'showimg_' +
                    index +
                    "','" +
                    e.message +
                    "')\"></div></div></div>" +
                    '<div class="showimg" id="showimg_' +
                    index +
                    '"></div>';
            } else if (nip != e.nip) {
                messages_el.innerHTML +=
                    '<div class="left-chat"> <div class="profile-info"> <img class="profile-pict" src="../data/' +
                    e.photo +
                    '" alt = "photo" onclick="exitpp(\'showpp_{{$index}}\', \'{{$chat->photo}}\')"><h2>' +
                    e.name +
                    '</h2></div><div class="wrap"><div class="container-chat"><img id="image_result" src="../forum/' +
                    e.message +
                    '" onclick="exit2(\'showimg_' +
                    index +
                    "','" +
                    e.message +
                    '\')"></div><div class="time">' +
                    timenow +
                    "</div></div></div>" +
                    '<div class="showimg" id="showimg_' +
                    index +
                    '"></div>';
            } else {
            }

            var content = document.getElementById("msg_wrap");
            if (content.style.display !== "none") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        } else if (e.type === "text") {
            if (nip == e.nip) {
                messages_el.innerHTML +=
                    '<div class="right-chat"><div class="wrap2"><div class="time2">' +
                    timenow +
                    '</div> <div class="container-chat2"><p>' +
                    e.message +
                    "</p></div></div></div>";
            } else if (nip != e.nip) {
                messages_el.innerHTML +=
                    '<div class="left-chat"> <div class="profile-info"> <img class="profile-pict" src="../data/' +
                    e.photo +
                    '" alt = "photo"><h2>' +
                    e.name +
                    '</h2></div><div class="wrap2"><div class="container-chat"><p>' +
                    e.message +
                    '</p></div><div class="time">' +
                    timenow +
                    "</div></div></div>";
            } else {
            }
        }

        message_input.value = null;
        file_input.value = null;
        message_input.removeAttribute("disabled");
        scrollToBottom();
    });


window.onload = function() {
    scrollToBottom();
};