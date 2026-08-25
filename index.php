<?php
include 'config.php';
include 'header.php';


$total = $conn->query("SELECT COUNT(*) AS total FROM slots")->fetch_assoc();
$available = $conn->query("SELECT COUNT(*) AS available FROM slots WHERE status='available'")->fetch_assoc();
$booked = $conn->query("SELECT COUNT(*) AS booked FROM slots WHERE status='booked'")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
<title>Smart Parking Slot Booking System </title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
scroll-behavior:smooth;
}
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
scroll-behavior:smooth;
}

/* BODY */
body{
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
color:white;
overflow-x:hidden;
}

/* NAVBAR */
.navbar{
position:fixed;
width:100%;
top:0;
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 50px;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(12px);
z-index:1000;
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

.logo{
font-size:26px;
font-weight:bold;
background:linear-gradient(45deg,#00dbde,#fc00ff);
-webkit-background-clip:text;
color:transparent;
}

.nav-links a{
margin-left:25px;
text-decoration:none;
color:white;
font-weight:500;
position:relative;
transition:0.3s;
}

.nav-links a::after{
content:'';
position:absolute;
width:0%;
height:2px;
left:0;
bottom:-5px;
background:#00dbde;
transition:0.3s;
}

.nav-links a:hover::after{
width:100%;
}

/* HERO */
.hero{
display:flex;
align-items:center;
justify-content:space-between;
padding:120px 60px 60px;
min-height:100vh;
gap:40px;
}

.hero-left{
width:50%;
animation:fadeLeft 1s ease;
}

.hero-left h1{
font-size:50px;
line-height:1.2;
margin-bottom:20px;
}

.hero-left span{
background:linear-gradient(45deg,#00dbde,#fc00ff);
-webkit-background-clip:text;
color:transparent;
}

.hero-left p{
font-size:18px;
color:#ddd;
margin-bottom:20px;
}

/* STATUS BOX */
.status-box{
margin-top:20px;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(10px);
padding:20px;
border-radius:15px;
width:260px;
box-shadow:0 10px 30px rgba(0,0,0,0.5);
border:1px solid rgba(255,255,255,0.2);
animation:fadeUp 1s ease;
}

.status-box h3{
margin-bottom:10px;
}

.total{color:#fff;}
.available{color:#00ff9f;}
.booked{color:#ff4b5c;}

/* IMAGE */
.hero-right{
width:50%;
display:flex;
justify-content:center;
animation:fadeRight 1s ease;
}

.hero-right img{
width:100%;
border-radius:20px;
box-shadow:0 25px 60px rgba(0,0,0,0.6);
transition:0.4s;
}

.hero-right img:hover{
transform:scale(1.05);
}

/* SECTION */
.section{
padding:100px 80px;
text-align:center;
background:linear-gradient(135deg,#141e30,#243b55);
}

.section h2{
font-size:34px;
margin-bottom:20px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
-webkit-background-clip:text;
color:transparent;
}

.section p{
width:70%;
margin:auto;
color:#ccc;
line-height:1.8;
}

/* CONTACT */
.contact{
padding:80px;
text-align:center;
background:#0f2027;
}

.contact input,
.contact textarea{
width:60%;
max-width:400px;
padding:12px;
margin:10px;
border-radius:10px;
border:none;
outline:none;
background:rgba(255,255,255,0.1);
color:white;
}

.contact input::placeholder,
.contact textarea::placeholder{
color:#bbb;
}

.contact button{
padding:12px 25px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
border:none;
border-radius:10px;
cursor:pointer;
font-weight:bold;
color:white;
transition:0.3s;
}

.contact button:hover{
transform:scale(1.08);
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

/* CHAT ICON */
.chat-icon{
position:fixed;
bottom:20px;
right:20px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
color:white;
padding:15px;
border-radius:50%;
cursor:pointer;
box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

/* CHATBOX */
.chatbot{
position:fixed;
bottom:80px;
right:20px;
width:300px;
background:rgba(0,0,0,0.85);
border-radius:15px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,0.6);
}

.chat-header{
background:linear-gradient(45deg,#00dbde,#fc00ff);
padding:10px;
text-align:center;
font-weight:bold;
}

.chat-body{
padding:10px;
height:200px;
overflow-y:auto;
font-size:14px;
}

.chat-body button{
margin:3px;
padding:5px 8px;
border:none;
border-radius:5px;
background:#333;
color:white;
cursor:pointer;
}

.chat-input{
display:flex;
}

.chat-input input{
flex:1;
padding:8px;
border:none;
outline:none;
}

.chat-input button{
background:#00dbde;
border:none;
padding:8px;
cursor:pointer;
}

/* FOOTER */
.footer{
text-align:center;
padding:20px;
background:black;
color:#aaa;
}
@media (max-width:768px){

.hero{
    flex-direction:column;
    padding:100px 20px;
}

.hero-left, .hero-right{
    width:100%;
    text-align:center;
}

.status-box{
    width:90%;
}

.navbar{
    flex-direction:column;
    padding:10px;
}
}
/* ANIMATION */
@keyframes fadeLeft{
from{opacity:0; transform:translateX(-40px);}
to{opacity:1; transform:translateX(0);}
}

@keyframes fadeRight{
from{opacity:0; transform:translateX(40px);}
to{opacity:1; transform:translateX(0);}
}

@keyframes fadeUp{
from{opacity:0; transform:translateY(40px);}
to{opacity:1; transform:translateY(0);}
}

/* RESPONSIVE */
@media(max-width:900px){
.hero{
flex-direction:column;
text-align:center;
}

.hero-left,
.hero-right{
width:100%;
}

.section p{
width:90%;
}

.contact input,
.contact textarea{
width:90%;
}
}
/* ===== HEADER ONLY UPGRADE ===== */

header, .header{
    position: sticky;
    top: 0;
    z-index: 1000;

    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 12px 20px;

    background: rgba(15, 20, 30, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);

    border-bottom: 1px solid rgba(255,255,255,0.08);

    box-shadow: 0 5px 20px rgba(0,0,0,0.4);
}

/* Logo / Title */
.header .logo{
    font-size: 20px;
    font-weight: 700;
    color: #00e5ff;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* NAV LINKS */
nav a, .header a{
    color: #ffffff;
    text-decoration: none;
    margin: 0 10px;
    font-weight: 500;
    position: relative;
    transition: 0.3s;
}

/* Hover effect underline animation */
nav a::after, .header a::after{
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 0%;
    height: 2px;
    background: linear-gradient(90deg,#00e5ff,#7c4dff);
    transition: 0.3s;
}

nav a:hover::after, .header a:hover::after{
    width: 100%;
}

nav a:hover, .header a:hover{
    color: #00e5ff;
}


</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
<div class="logo">🚗 Smart Parking</div>
<div class="nav-links">
<a href="#">Home</a>
<a href="#about">About</a>
<a href="admin_login.php">Admin</a>
<a href="user_login.php">User</a>
<a href="#contact">Contact</a>
<a href="map.php">View Parkinng Map</a>


</div>
</div>
<!DOCTYPE html>
<html>
<head>
    <title>Parking AI Chatbot</title>

</head>
<body>
<!-- Chat Icon -->
<!-- Chat Icon -->
<div class="chat-icon" onclick="toggleChat()">💬</div>

<!-- Chatbot -->
<div class="chatbot" id="chatbotBox" style="display:none;">
    <div class="chat-header">Parking AI Chatbot</div>

    <div class="chat-body" id="chatBody">
        <p><b>Bot:</b> Hello! Select a question:</p>

        <button onclick="quickMsg('available slots')">Available Slots</button>
        <button onclick="quickMsg('price')">Parking Price</button>
        <button onclick="quickMsg('location')">Parking Location</button>
        <button onclick="quickMsg('book')">How to Book</button>
        <button onclick="quickMsg('cancel')">Cancel Booking</button>
        <button onclick="quickMsg('contact')">Contact</button>
    </div>

    <div class="chat-input">
        <input type="text" id="userMessage" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>
<script>
function toggleChat() {
    var chat = document.getElementById("chatbotBox");
    chat.style.display = (chat.style.display === "none") ? "block" : "none";
}

function sendMessage() {
    var input = document.getElementById("userMessage");
    var msg = input.value;
    var chatBody = document.getElementById("chatBody");

    if(msg.trim() === "") return;

    chatBody.innerHTML += "<p><b>You:</b> " + msg + "</p>";

    var text = msg.toLowerCase();
    var reply = "";

    if(text.includes("hi") || text.includes("hello"))
        reply = "Hello!!!! Welcome to Smart Parking.";
    else if(text.includes("slot") || text.includes("available"))
        reply = "Available slots: <?php echo $available['available']; ?>";
    else if(text.includes("price"))
        reply = "Parking price Rs 200 per hour.";
    else if(text.includes("location"))
        reply = "Parking near Bus Stand.";
    else if(text.includes("book"))
        reply = "Go to User → Book Slot → Select slot.";
    else if(text.includes("cancel"))
        reply = "Go to My Bookings → Cancel.";
    else if(text.includes("contact"))
        reply = "Contact Admin";
    else
        reply = "Please select a question.";

    chatBody.innerHTML += "<p style='color:green;'><b>Bot:</b> " + reply + "</p>";

    chatBody.scrollTop = chatBody.scrollHeight;
    input.value = "";
}

function quickMsg(text) {
    document.getElementById("userMessage").value = text;
    sendMessage();
}

// Enter key send
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("userMessage").addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });
});
</script>
</body>
</html>

<!-- HERO SECTION -->
<div class="hero">
<div class="hero-left">
<h1>Book Your <span>Smart Parking Slot</span><br> Anytime, Anywhere</h1>

<p>Aws and Devops Automation, Real-time slot availability, Live Navigation, SMS alerts, Secure Payment and Auto Release System.</p>
</div>

<div class="hero-right">
<img src="https://images.unsplash.com/photo-1502877338535-766e1452684a" alt="Parking Image">
</div>
<div class="status-box">
    <h3>Live Parking Status</h3>
    <p class="total">Total Slots: <?php echo $total['total']; ?></p>
    <p class="available">Available Slots: <?php echo $available['available']; ?></p>
    <p class="booked">Booked Slots: <?php echo $booked['booked']; ?></p>
</div>
<!-- FLOATING BOOKING CARD -->


</div>

<!-- ABOUT -->
<div id="about" class="section">
<h2>About Smart Parking System</h2>
<p>
Smart Parking Slot Booking System allows users to reserve parking spaces online.
It provides real-time availability tracking, auto release after booking expiry,
secure payment integration, SMS alerts, and Google Map navigation to exact parking coordinates.
Admins can manage users, slots, payments and bookings efficiently.
</p>
</div>

<!-- CONTACT -->
<div id="contact" class="contact">
<h2>Contact Us</h2>
<input type="text" placeholder="Your Name"><br>
<input type="email" placeholder="Your Email"><br>
<textarea rows="4" placeholder="Your Message"></textarea><br>
<button>Send Message</button>
</div>

<!-- FOOTER -->
<div class="footer">
© 2026 Smart Parking Slot Booking System | Final Year Project
</div>

</body>
</html>
<?php include 'footer.php'; ?>
