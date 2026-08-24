<?php
include 'config.php';
include 'auto_release.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

/* CANCEL BOOKING */
if(isset($_GET['cancel'])){
$id = $_GET['cancel'];

$row = $conn->query("SELECT slot_id FROM bookings WHERE id='$id'")->fetch_assoc();

$conn->query("UPDATE bookings SET status='Cancelled' WHERE id='$id'");
$conn->query("UPDATE slots SET status='Available' WHERE id=".$row['slot_id']);

echo "<script>alert('Booking Cancelled Successfully');window.location='my_booking.php';</script>";
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>

<style>
body{
margin:0;
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
color:white;
text-align:center;
padding:40px 10px;
}

/* TITLE */
h2{
margin-bottom:30px;
font-size:28px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
-webkit-background-clip:text;
color:transparent;
}

/* CARD */
.card{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(15px);
padding:25px;
margin:20px auto;
width:400px;
border-radius:20px;
box-shadow:0 15px 40px rgba(0,0,0,0.6);
border:1px solid rgba(255,255,255,0.2);
text-align:left;
animation:fadeUp 0.8s ease;
transition:0.3s;
}

/* HOVER EFFECT */
.card:hover{
transform:translateY(-8px);
box-shadow:0 20px 50px rgba(0,0,0,0.8);
}

/* TEXT */
.card b{
color:#00dbde;
}

/* STATUS */
.status-booked{
color:#00ff9f;
font-weight:bold;
}

.status-cancelled{
color:#ff4b5c;
font-weight:bold;
}

/* BUTTON */
.btn{
padding:10px 16px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
color:white;
text-decoration:none;
border-radius:20px;
margin:5px 5px 0 0;
display:inline-block;
font-weight:bold;
transition:0.3s;
box-shadow:0 5px 15px rgba(0,0,0,0.4);
}

.btn:hover{
transform:scale(1.08);
}

/* BACK BUTTON SPECIAL */
.btn:last-child{
margin-top:20px;
}

/* ANIMATION */
@keyframes fadeUp{
from{opacity:0; transform:translateY(30px);}
to{opacity:1; transform:translateY(0);}
}

/* RESPONSIVE */
@media(max-width:500px){
.card{
width:90%;
}

}
</style>
</head>
<body>

<h2>🚗 My Bookings</h2>

<?php
$result = $conn->query("SELECT bookings.*, slots.latitude, slots.longitude 
FROM bookings 
JOIN slots ON bookings.slot_id = slots.id
WHERE user_id=".$_SESSION['user_id']." 
ORDER BY bookings.id DESC");

while($r = $result->fetch_assoc()){
?>

<div class="card">

📍 <b>Location:</b> <?php echo $r['location']; ?><br>
🅿 <b>Slot:</b> <?php echo $r['slot_number']; ?><br>

<?php if(isset($r['from_date'])){ ?>
📅 <b>From:</b> <?php echo $r['from_date']; ?><br>
📅 <b>To:</b> <?php echo $r['to_date']; ?><br>
📆 <b>Total Days:</b> <?php echo $r['total_days']; ?><br>
<?php } else { ?>
📅 <b>Date:</b> <?php echo $r['booking_date']; ?><br>
⏰ <b>Time:</b> <?php echo $r['booking_time']; ?><br>
<?php } ?>

💰 <b>Amount:</b> ₹<?php echo $r['amount']; ?><br>

📌 <b>Status:</b> 
<span class="<?php echo strtolower('status-'.$r['status']); ?>">
<?php echo $r['status']; ?>
</span>

<br><br>

<!-- GOOGLE MAP NAVIGATION -->
<a class="btn" 
href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $r['latitude']; ?>,<?php echo $r['longitude']; ?>" 
target="_blank">
🗺 Navigate
</a>



</div>

<?php } ?>

<br>
<a class="btn" href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
