<?php
include 'config.php';
include 'sms.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

$booking_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$bookingQuery = $conn->query("SELECT * FROM bookings WHERE id='$booking_id' AND user_id='$user_id'");
$booking = $bookingQuery->fetch_assoc();

if($booking){
    $slot_id = $booking['slot_id'];

    // 🔥 FIX: get phone from users table
    $userQuery = $conn->query("SELECT phone FROM users WHERE id='$user_id'");
    $user = $userQuery->fetch_assoc();
    $phone = $user['phone'] ?? '';

    // 🔥 FIX: add +91 if missing
    if($phone && substr($phone,0,3) != "+91"){
        $phone = "+91".$phone;
    }

    // Cancel booking
    $conn->query("UPDATE bookings SET status='cancelled' WHERE id='$booking_id'");
    $conn->query("UPDATE slots SET status='Available' WHERE id='$slot_id'");

    // Send SMS
    if(!empty($phone)){
        $message = "Soory!!\nYour parking booking cancelled and slot released.\nBy Admin";
        sendSMS($phone, $message);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Cancel Booking</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#141e30,#243b55);
}

.card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(12px);
    padding:30px;
    border-radius:15px;
    text-align:center;
    width:350px;
    box-shadow:0 8px 25px rgba(0,0,0,0.4);
    color:white;
}

.success{
    color:#00ffcc;
    font-size:20px;
    margin-bottom:15px;
}

.error{
    color:#ffcc00;
    margin-bottom:15px;
}

button{
    padding:12px 20px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#ff416c,#ff4b2b);
    color:white;
    cursor:pointer;
    margin-top:15px;
    width:100%;
    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
    background:linear-gradient(45deg,#00c6ff,#0072ff);
}

a{
    text-decoration:none;
}
</style>

</head>

<body>

<div class="card">

<?php
if($booking){
    $slot_id = $booking['slot_id'];
    $phone = "+918531976986";

    $conn->query("UPDATE bookings SET status='cancelled' WHERE id='$booking_id'");
    $conn->query("UPDATE slots SET status='Available' WHERE id='$slot_id'");

    $message = "SORRY!! Your parking booking cancelled and slot released. \n By admin";
    sendSMS($phone, $message);
?>
    <div class="success">✅ Booking Cancelled</div>
    <p>Slot released successfully & SMS sent.</p>

    <a href="admin_dashboard.php?page=bookings">
        <button>🏠 Back to View Booking</button>
    </a>

<?php
} else {
?>
    <div class="error">⚠ Booking not found</div>

    <a href="admin_dashboard.php?page=bookings">
        <button>⬅ Back to View Booking</button>
    </a>
<?php
}
?>

</div>

</body>
</html>