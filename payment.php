<?php
require_once 'config.php';
require_once 'sms.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

$success = false;
$error = "";
$qr_id = "";

/* STORE BOOKING */
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['pay'])){
    $_SESSION['booking'] = $_POST;
}

/* SESSION CHECK */
if(!isset($_SESSION['booking'])){
    header("Location: booking.php");
    exit();
}

/* PAYMENT PROCESS */
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])){

    $data = $_SESSION['booking'];
    $vehicle = $data['vehicle_no'] ?? '';
    $slot_id   = $data['slot_id'] ?? '';
    $from_date = $data['from_date'] ?? '';
    $to_date   = $data['to_date'] ?? '';
    $from_time = $data['from_time'] ?? '';
    $to_time   = $data['to_time'] ?? '';
    $days      = $data['days'] ?? '';
    $amount    = preg_replace('/[^0-9]/', '', $data['amount'] ?? '');

    if(empty($slot_id) || empty($days) || empty($amount)){
        $error = "⚠ Booking data missing.";
    } else {

        $user_id = $_SESSION['user_id'];

        $userQuery = $conn->query("SELECT phone FROM users WHERE id='$user_id'");

        if($userQuery && $userQuery->num_rows > 0){

            $user = $userQuery->fetch_assoc();
            $phone = $user['phone'];

            $slotQuery = $conn->query("SELECT * FROM slots WHERE id='$slot_id' AND status='Available'");

            if($slotQuery && $slotQuery->num_rows > 0){

                $slot = $slotQuery->fetch_assoc();

                $today = date("Y-m-d");
                $time  = date("H:i:s");

                $insert = $conn->query("INSERT INTO bookings 
                (user_id, slot_id, location, slot_number, booking_date, booking_time, 
                 from_date, to_date,from_time, to_time, total_days, amount,vehicle_no, status)
                VALUES
                ('$user_id','$slot_id','".$slot['location']."','".$slot['slot_number']."',
                '$today','$time','$from_date','$to_date','$from_time','$to_time','$days','$amount','$vehicle','Booked')");

                if($insert){

                    $qr_id = $conn->insert_id; // 🔥 QR ID

                    $conn->query("UPDATE slots SET status='Booked' WHERE id='$slot_id'");

                    $mapsLink = "https://www.google.com/maps/dir/?api=1&destination="
                                .$slot['latitude'].",".$slot['longitude'];

                    $message = "Successfully!\nParking Booking Confirmed\n".
                               "Slot: ".$slot['slot_number']."\n".
                               "Amount: Rs ".$amount."\n".
                               "Map: ".$mapsLink;

                    sendSMS($phone, $message);

                    unset($_SESSION['booking']);
                    $success = true;

                } else {
                    $error = "❌ Booking Failed";
                }

            } else {
                $error = "⚠ Slot Already Booked";
            }

        } else {
            $error = "❌ User Not Found";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>

<style>
body{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
color:white;
font-family:Poppins;
}

.box{
background:rgba(255,255,255,0.08);
padding:30px;
border-radius:20px;
width:360px;
text-align:center;
backdrop-filter:blur(10px);
}

button{
width:100%;
padding:10px;
margin-top:10px;
border:none;
border-radius:8px;
background:#00dbde;
cursor:pointer;
}

a{
display:block;
margin-top:10px;
color:#ccc;
text-decoration:none;
}

.success{color:#00ffcc;}
.error{color:yellow;}

.qr-box{
margin-top:20px;
background:#111;
padding:15px;
border-radius:10px;
}
</style>
</head>

<body>

<div class="box">

<?php if($success){ ?>

<h2 class="success">✅ Booking Successful</h2>
<p>SMS Sent + Navigation Link</p>

<div class="qr-box">
<h3>Scan QR at Entry</h3>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://cone-upload-strangely.ngrok-free.dev/slot_Booking/scan.php?id=<?php echo $qr_id; ?>">

<p>ID: <?php echo $qr_id; ?></p>
</div>

<a href="my_booking.php">My Booking</a>
<a href="dashboard.php">Dashboard</a>

<?php } else { ?>

<?php if($error!=""){ ?>
<p class="error"><?php echo $error; ?></p>
<?php } ?>

<h3>Confirm Payment</h3>

<p>Days: <b><?php echo $_SESSION['booking']['days'] ?? 0; ?></b></p>
<p>Amount: ₹<b><?php echo $_SESSION['booking']['amount'] ?? 0; ?></b></p>

<form method="post">
<button name="pay">Pay Now</button>
</form>

<a href="booking.php">⬅ Back</a>

<?php } ?>

</div>

</body>
</html>