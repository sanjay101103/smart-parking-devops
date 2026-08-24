
<?php
// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Default Admin Credentials
    $default_username = "admin";
    $default_password = "admin123";

    if($username === $default_username && $password === $default_password){
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login - Parking Slot Booking</title>

<style>

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,#020617,#1e293b);
}

/* HEADER */
.header {
    background: #020617;
    color: white;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #1f2937;
}

/* LOGIN BOX */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 85vh;
}

.login-box {
    background: #020617;
    padding: 40px;
    border-radius: 15px;
    width: 350px;
    text-align: center;
    box-shadow: 0 0 30px rgba(0,0,0,0.6);
}

h2 {
    color: #38bdf8;
}

/* INPUT */
input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #1f2937;
    background: #0f172a;
    color: white;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    background: #3b82f6;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #2563eb;
}

.error {
    color: red;
}
/* HEADER */
.header {
    background: #020617;
    color: white;
    padding: 15px 20px;
    text-align: center;
    position: relative;
    font-size: 20px;
    font-weight: bold;
    border-bottom: 1px solid #1f2937;
}

/* BACK BUTTON */
.back-btn {
    position: absolute;
    left: 20px;
    top: 12px;
    background: #3b82f6;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.back-btn:hover {
    background: #2563eb;
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

<h2>Admin Login</h2>

<?php if($error != ""){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

</div>
</div>

</body>
</html>
