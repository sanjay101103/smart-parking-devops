<?php
include 'config.php';

// Safe session start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");

    if($query && mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: dashboard.php");
        exit();
    }else{
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login - Parking Slot Booking</title>

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
height:100vh;
}

/* HEADER */
.header{
background:rgba(255,255,255,0.1);
backdrop-filter:blur(10px);
color:white;
padding:15px 30px;
display:flex;
align-items:center;
justify-content:center;
position:relative;
font-size:22px;
font-weight:bold;
letter-spacing:1px;
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

/* BACK BUTTON */
.back-btn{
position:absolute;
left:20px;
background:rgba(0,0,0,0.5);
color:white;
padding:8px 15px;
border-radius:8px;
text-decoration:none;
font-size:14px;
transition:0.3s;
}

.back-btn:hover{
background:white;
color:#ff4b2b;
}

/* CONTAINER */
.container{
display:flex;
justify-content:center;
align-items:center;
height:85vh;
}

/* BOX (COMMON) */
.login-box, .register-box{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(15px);
padding:40px;
border-radius:20px;
width:360px;
text-align:center;
box-shadow:0 15px 35px rgba(0,0,0,0.6);
animation:fadeIn 0.8s ease-in-out;
border:1px solid rgba(255,255,255,0.2);
}

/* TITLE */
h2{
color:white;
margin-bottom:20px;
}

/* INPUT */
input{
width:100%;
padding:12px;
margin:12px 0;
border:none;
border-radius:10px;
outline:none;
background:rgba(255,255,255,0.15);
color:white;
font-size:14px;
transition:0.3s;
}

input::placeholder{
color:#ddd;
}

input:focus{
background:rgba(255,255,255,0.25);
transform:scale(1.03);
}

/* BUTTON */
button{
width:100%;
padding:12px;
background:linear-gradient(45deg,#ff416c,#ff4b2b);
color:white;
border:none;
border-radius:10px;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

button:hover{
transform:scale(1.05);
box-shadow:0 5px 15px rgba(0,0,0,0.4);
}

/* LINKS */
.register-link, .login-link{
display:block;
margin-top:15px;
color:#fff;
text-decoration:none;
font-weight:bold;
}

.register-link:hover, .login-link:hover{
color:#ff4b2b;
}

/* ANIMATION */
@keyframes fadeIn{
from{opacity:0; transform:translateY(30px);}
to{opacity:1; transform:translateY(0);}
}
</style>

</head>
<body>

<!-- HEADER -->
<div class="header">
<a href="index.php" class="back-btn">⬅ Back</a>
🚗 Parking Slot Booking System
</div>

<div class="container">
<div class="login-box">
<h2>User Login</h2>

<form method="post">
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

<a href="user_register.php" class="register-link">New User? Register Here</a>

</div>
</div>

</body>
</html>
