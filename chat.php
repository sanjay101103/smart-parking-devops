<!DOCTYPE html>
<html>
<head>
    <title>Parking AI Chatbot</title>
    
</head>
<body>

<div class="chat-container">
    <div class="chat-header">🚗 Parking AI Chatbot</div>
    <div class="chat-box" id="chatBox"></div>

    <div class="input-box">
        <input type="text" id="msg" placeholder="Ask about parking...">
        <button onclick="sendMsg()">Send</button>
    </div>
</div>

<script>
function sendMsg() {
    var message = document.getElementById("msg").value;
    var chatBox = document.getElementById("chatBox");

    chatBox.innerHTML += "<div class='user'>You: " + message + "</div>";

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "chatbot.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        chatBox.innerHTML += "<div class='bot'>Bot: " + this.responseText + "</div>";
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    xhr.send("message=" + message);
    document.getElementById("msg").value = "";
}
</script>

</body>
</html>