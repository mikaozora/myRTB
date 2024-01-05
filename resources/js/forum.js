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

        console.log(e);

        //buat tanggal
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };

        const edate = new Date(e.created_at);
        const hours = edate.getHours().toString().padStart(2, "0");
        const minutes = edate.getMinutes().toString().padStart(2, "0");
        const timenow = hours + ":" + minutes;

        console.log(edate);
        let date = "";
        let formattedDate = "";
        let eventNow = edate;
        let temp = false;
        eventNow.setHours(0, 0, 0, 0);
        let eventNowDate = new Date(eventNow);
        if (lastCreatedAt === "null") {
            if (eventBefore.getTime() !== eventNowDate.getTime()) {
                console.log(typeof (eventBefore));
                console.log(typeof (eventNowDate));
                temp = true;
            } else {
                temp = false;
            }
            date = edate;
        } else if (lastCreatedAt !== "null") {
            eventBefore.setHours(0, 0, 0, 0);
            date = new Date(lastCreatedAt);
            console.log("eventBefore " + eventBefore);
            console.log("eventNow "+ eventNowDate)
            if (eventBefore.getTime() !== eventNowDate.getTime()) {
                console.log("eventBefore !== eventNow2");
                temp = true;
            } else {
                temp = false;
            }
        }
        // console.log("eventNow" + eventNow);
        // console.log("eventBefore" + eventBefore);

        formattedDate = date.toLocaleDateString("id-ID", options);

        const eformattedDate = edate.toLocaleDateString("id-ID", options);

        // console.log(formattedDate);
        // console.log(eformattedDate);

        if (formattedDate !== eformattedDate || temp) {
            datenow.innerHTML +=
                '<dic class="datenow"><h1>' + eformattedDate + "</h1></div>";
        }
        
        eventBefore = eventNowDate;

        if (e.type === "img") {
            if (nip == e.nip) {
                messages_el.innerHTML +=
                    '<div class="right-chat"><div class="wrap2"><div class="time2">' +
                    timenow +
                    '</div> <div class="container-chat2"><img id="image_result" src="../forum/' +
                    e.message +
                    '"></div></div></div>';
            } else if (nip != e.nip) {
                messages_el.innerHTML +=
                    '<div class="left-chat"> <div class="profile-info"> <img class="profile-pict" src="../data/' +
                    e.photo +
                    '" alt = "photo"><h2>' +
                    e.name +
                    '</h2></div><div class="wrap"><div class="container-chat"><img id="image_result" src="../forum/' +
                    e.message +
                    '"></div><div class="time">' +
                    timenow +
                    "</div></div></div>";
            } else {
                console.log("failed");
            }

            var content = document.getElementById("msg_wrap");
            if (content.style.display !== "none") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }

        } else if (e.type === "text") {
            console.log("test");
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
                console.log("failed");
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
