<?php 
include 'config.php'; 
include 'auto_release.php'; 

// Safe session start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Protect page
if(!isset($_SESSION['user_name'])){
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<title>User Dashboard - Smart Parking</title>

<style>
body{
margin:0;
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
color:white;
}

/* HEADER */
.header{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(12px);
padding:15px 40px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

.header h2{
margin:0;
background:linear-gradient(45deg,#00dbde,#fc00ff);
-webkit-background-clip:text;
color:transparent;
}

/* LOGOUT BUTTON */
.logout{
background:linear-gradient(45deg,#ff416c,#ff4b2b);
padding:8px 18px;
border-radius:20px;
text-decoration:none;
color:white;
font-weight:bold;
transition:0.3s;
}

.logout:hover{
transform:scale(1.05);
box-shadow:0 5px 15px rgba(0,0,0,0.5);
}

/* SIDEBAR */
.sidebar{
width:230px;
height:100vh;
background:rgba(255,255,255,0.05);
backdrop-filter:blur(10px);
position:fixed;
padding-top:30px;
border-right:1px solid rgba(255,255,255,0.1);
}

.sidebar a{
display:block;
padding:15px 25px;
color:white;
text-decoration:none;
margin:10px;
border-radius:10px;
transition:0.3s;
font-weight:500;
}

.sidebar a:hover{
background:linear-gradient(45deg,#00dbde,#fc00ff);
transform:translateX(5px);
}

/* MAIN */
.main{
margin-left:250px;
padding:40px;
}

/* CARD */
.card{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(15px);
padding:40px;
border-radius:20px;
box-shadow:0 15px 40px rgba(0,0,0,0.6);
text-align:center;
animation:fadeUp 0.8s ease;
border:1px solid rgba(255,255,255,0.2);
}

.card h3{
margin-bottom:15px;
font-size:22px;
}

.card p{
color:#ddd;
}

/* ANIMATION */
@keyframes fadeUp{
from{opacity:0; transform:translateY(30px);}
to{opacity:1; transform:translateY(0);}
}

/* RESPONSIVE */
@media(max-width:900px){

.sidebar{
width:100%;
height:auto;
position:relative;
display:flex;
justify-content:center;
flex-wrap:wrap;
}

.sidebar a{
margin:5px;
padding:10px 15px;
}

.main{
margin-left:0;
padding:20px;
}
}
</style>

</head>
<body>

<!-- HEADER -->
<div class="header">
<h2>🚗 Smart Parking - User Panel</h2>
<a href="logout.php" class="logout">Logout</a>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
<a href="dashboard.php">🏠 Dashboard</a>
<a href="viewslot.php">🚘 View Slots</a>
<a href="booking.php">🚘 Slot Booking</a>
<a href="my_booking.php">📅 My Booking</a>
<a href="index.php">👤 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">
<div class="card">
<h3>Welcome <?php echo $_SESSION['user_name']; ?> 👋</h3>
<p>Select an option from the sidebar to continue.</p>
</div>
</div>

</body>
</html>
