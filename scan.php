<?php
session_start();
include 'config.php';

$id = $_GET['id'] ?? '';
$status = false;
$row = null;

if($id){
$q = $conn->query("SELECT * FROM bookings WHERE id='$id' AND status='Booked'");

if($q && $q->num_rows > 0){
$row = $q->fetch_assoc();

/* Expiry check */
$today = date("Y-m-d");
if($row['to_date'] >= $today){
$status = true;
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Gate Entry</title>

<style>
body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
font-family:Poppins;
color:white;
}

/* CARD */
.box{
background:rgba(255,255,255,0.1);
padding:30px;
border-radius:20px;
text-align:center;
width:350px;
box-shadow:0 10px 40px rgba(0,0,0,0.5);
}

/* PAYMENT BOX */
.payment{
background:rgba(255,255,255,0.08);
padding:15px;
border-radius:10px;
margin-top:10px;
text-align:left;
font-size:14px;
}

/* GATE */
.gate{
margin-top:20px;
height:100px;
background:#111;
position:relative;
overflow:hidden;
border-radius:10px;
}

.bar{
position:absolute;
width:100%;
height:100%;
background:lime;
transform:translateY(0);
transition:1s ease;
}

/* ANIMATION */
.open .bar{
transform:translateY(-100%);
box-shadow:0 0 20px lime;
}

/* TEXT */
.success{color:#00ffcc;}
.error{color:#ff4b5c;}

a{
display:block;
margin-top:15px;
color:#ccc;
text-decoration:none;
}

/* BUTTON */
.btn{
background:#00ffcc;
color:black;
padding:10px;
border-radius:8px;
display:inline-block;
margin-top:15px;
text-decoration:none;
font-weight:bold;
}
</style>
</head>

<body>

<div class="box" id="gateBox">

<?php if($status && $row){ ?>

<h2 class="success">✅ Access Granted</h2>
<p>Gate Opening 🚧</p>

<!-- PAYMENT DETAILS -->
<div class="payment">
<b>Booking ID:</b> <?php echo $row['id']; ?><br>

<b>Vehicle No:</b> <?php echo $row['vehicle_no']; ?><br>
<b>From:</b> <?php echo $row['from_date']; ?><br>
<b>To:</b> <?php echo $row['to_date']; ?><br>
<b>Amount Paid:</b> ₹<?php echo isset($row['amount']) ? $row['amount'] : '100'; ?>
</div>

<!-- GATE -->
<div class="gate">
<div class="bar"></div>
</div>

<!-- DOWNLOAD BUTTON -->
<a href="download_pdf.php?id=<?php echo $row['id']; ?>" class="btn">
📄 Download Receipt
</a>

<?php } else { ?>

<h2 class="error">❌ Access Denied</h2>
<p>Invalid / Expired Booking</p>

<?php } ?>


<a href="index.php">⬅ Back</a>

</div>

<script>
window.onload = function(){
<?php if($status){ ?>
setTimeout(function(){
document.getElementById("gateBox").classList.add("open");
}, 500);
<?php } ?>
}
</script>

</body>
</html>