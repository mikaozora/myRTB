import "./bootstrap";
import axios from "axios";
 
const messages_el = document.getElementById("messages");
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form");

const file_input = document.getElementById("file_input");

const currentPath = window.location.pathname; 

const nip = laravelSessionData.NIP;

console.log(lastCreatedAt);

function scrollToBottom() {
    messages_el.scrollTop = messages_el.scrollHeight;
}

message_form.addEventListener("submit", function (e) {
    e.preventDefault();

    let has_errors = false;

    if (message_input.value === "" && file_input.value === "") {
        alert("please enter message");
        has_errors = true;
    }

    if (has_errors) {
        return;
    }
    console.log(file_input.value);
    console.log(message_input.value);
    if (message_input.value === "") {
        console.log("mesg_input null");
        message_input.value = file_input.value;
    } else if (file_input.value === "") {
        console.log("file_input null");
    }
    const formData = new FormData();

    formData.append("photo", file_input.value);
    formData.append("message", message_input.value);
    
    const options = {
        method: "post",
        url: currentPath + "/send-msg",
        data: formData,
        headers: {
            "content-type": "multipart/form-data",
        },
    };

    axios.interceptors.request.use(
        (config) => {
            if (config.headers["Content-Type"] !== "multipart/form-data") {
                config.headers["Content-Type"] = "multipart/form-data";
            }

            return config;
        },
        (error) => {
            // Handle request error
            return Promise.reject(error);
        }
    );

    // fetch(currentPath + "/send-msg", {
    //     method: "POST",
    //     body: formData,
    //     headers: {
    //         "Content-Type": "multipart/form-data",
    //     },
    // }).then((response) => response.json());

    axios(options).then(res=>{console.log(res)});
    
    scrollToBottom();
});

// const datenow = document.getElementById("datenow")

window.Echo.channel('chat')
    .listen('.message', (e) => {
        console.log(e);

        //buat tanggal
        const date = new Date(lastCreatedAt);

        const edateOnly = e.created_at.substring(0, 10);
        const etimeOnly = e.created_at.substring(12,16)
        const edate = new Date(edateOnly);

        console.log(e.created_at);
        console.log(date.getDate());


        if (date===edate) {
            datenow.innerHTML +=
                '<h1>' +
                e.created_at +
                '</h1>'
        }
        

        if (file_input.value != "") {
            console.log(file_input.files[0].name);
            console.log("ini file");
            if (nip == e.nip) {
                messages_el.innerHTML +=
                    '<div class="right-chat"><div class="wrap2"><div class="time2">' +
                    etimeOnly +
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
                    etimeOnly +
                    "</div></div></div>";
            } else {
                console.log("failed");
            }

        } else if (message_input.value != "") {
            if (nip == e.nip) {
                messages_el.innerHTML +=
                    '<div class="right-chat"><div class="wrap2"><div class="time2">' +
                    etimeOnly +
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
                    etimeOnly +
                    "</div></div></div>";
            } else {
                console.log("failed");
            }
        }
    });

// var bottomBox = document.getElementById('messages');

// function scrollToBottom() {
//     bottomBox.scrollTop = bottomBox.scrollHeight;
// }

// document.getElementById('message_form').addEventListener('submit', function() {
//     scrollToBottom();
// });

window.onload = function() {
    scrollToBottom();
};
