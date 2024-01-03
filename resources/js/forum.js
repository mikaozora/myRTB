import "./bootstrap";
import axios from "axios";
 
const messages_el = document.getElementById("messages");
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form");

const file_input = document.getElementById("file_input");

const currentPath = window.location.pathname; 

const nip = laravelSessionData.NIP;


function scrollToBottom() {
    messages_el.scrollTop = messages_el.scrollHeight;
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
        // console.log("mesg_input null");
        message_input.value = file_input.value;
    } else if (file_input.value === "") {
        // console.log("file_input null");
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

    axios(options);
    
    scrollToBottom();

    
});


window.Echo.channel('chat')
    .listen('.message', (e) => {
        console.log(e);

    //buat tanggal
        const date = new Date(lastCreatedAt);
        const edate = new Date(e.created_at);

        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        const eformattedDate = edate.toLocaleDateString("id-ID", options);
        const formattedDate = date.toLocaleDateString("id-ID", options);

        const hours = edate.getHours().toString().padStart(2, "0"); 
        const minutes = edate.getMinutes().toString().padStart(2, "0");

        const timenow = hours + ":" + minutes;

        if (formattedDate !== eformattedDate) {
            datenow.innerHTML +=
                '<dic class="datenow"><h1>' + eformattedDate + "</h1></div>";
        }
        
        if (file_input.value != "") {
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

        } else if (message_input.value != "") {
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

        var content = document.getElementById('msg_wrap');
        var fileInput = document.getElementById('file_input');
        if (content.style.display !== 'none') {
            content.style.display = 'none';
        } else {
            content.style.display = 'block';
        }
        
        message_input.value = null;
        file_input.value = null;
    });


window.onload = function() {
    scrollToBottom();
};
