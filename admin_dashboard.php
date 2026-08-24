
<?php
include 'config.php';
include 'sms.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

/* CANCEL BOOKING */
if(isset($_GET['cancel_id'])){

    $id = intval($_GET['cancel_id']);

    $booking = mysqli_query($conn,"SELECT * FROM bookings WHERE id='$id'");
    $row = mysqli_fetch_assoc($booking);

    if($row && $row['status'] == 'Booked'){

        mysqli_query($conn,"UPDATE bookings SET status='Cancelled' WHERE id='$id'");
        mysqli_query($conn,"UPDATE slots SET status='Available' WHERE id='".$row['slot_id']."'");

        $phone = $row['phone'];

        $message = "Your Booking Has Been Cancelled By Admin.
Slot: ".$row['slot_number']."
Location: ".$row['location']."
Amount: ₹".$row['amount'];

        sendSMS($phone, $message);

        echo "<script>
        alert('Booking Cancelled & SMS Sent');
        window.location='admin_dashboard.php?page=bookings';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(135deg,#020617,#0f172a,#020617);
    color:#e2e8f0;
}

/* HEADER */
.header{
    background: rgba(2,6,23,0.8);
    backdrop-filter: blur(10px);
    padding:20px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid rgba(255,255,255,0.08);
    position:sticky;
    top:0;
}

.logout{
    background:linear-gradient(45deg,#ef4444,#dc2626);
    padding:8px 18px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.logout:hover{
    transform:scale(1.05);
}

/* SIDEBAR */
.sidebar{
    width:240px;
    height:100vh;
    position:fixed;
    background: rgba(2,6,23,0.95);
    backdrop-filter: blur(12px);
    border-right:1px solid rgba(255,255,255,0.08);
    padding-top:30px;
}

.sidebar a{
    display:flex;
    gap:10px;
    padding:14px 20px;
    margin:5px 10px;
    border-radius:10px;
    color:#94a3b8;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:linear-gradient(45deg,#3b82f6,#06b6d4);
    color:white;
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:260px;
    padding:30px;
}

/* CARD */
.card{
    background: rgba(2,6,23,0.7);
    backdrop-filter: blur(12px);
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:linear-gradient(45deg,#1e293b,#334155);
    padding:14px;
    color:#38bdf8;
}

td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

tr:hover{
    background:rgba(59,130,246,0.1);
}

/* BUTTON */
.cancel-btn{
    background:linear-gradient(45deg,#ef4444,#dc2626);
    padding:6px 14px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.cancel-btn:hover{
    transform:scale(1.05);
}

/* DASHBOARD BOX */
.dashboard-box{
    flex:1;
    background:linear-gradient(135deg,#1e293b,#0f172a);
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
    transition:0.3s;
}

.dashboard-box:hover{
    transform:translateY(-5px);
}

.dashboard-box h1{
    font-size:32px;
    color:#22c55e;
}

/* ANIMATION */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}
</style>

</head>

<body>

<div class="header">
<h2>🚗 Admin Dashboard</h2>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="sidebar">
<a href="admin_dashboard.php?page=dashboard">🏠 Dashboard</a>
<a href="admin_dashboard.php?page=users">👥 Users</a>
<a href="admin_dashboard.php?page=bookings">📅 Bookings</a>
</div>

<div class="main">
<div class="card">

<?php

/* DASHBOARD */
if($page == 'dashboard'){

    $totalUsers = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
    $totalBookings = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bookings WHERE status='Booked'"));

    echo "<h3>Welcome Admin 👋</h3>

    <div style='display:flex; gap:20px; margin-top:20px; flex-wrap:wrap;'>

        <div class='dashboard-box'>
            <h3>Total Users 👤</h3>
            <h1>$totalUsers</h1>
        </div>

        <div class='dashboard-box'>
            <h3>Active Bookings 🎟️</h3>
            <h1>$totalBookings</h1>
        </div>

    </div>";
}

/* USERS */
if($page == 'users'){

    echo "<h3>👥 User Details</h3><table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>";

    $users = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");

    while($row = mysqli_fetch_assoc($users)){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone']}</td>
        </tr>";
    }

    echo "</table>";
}

/* BOOKINGS */
if($page == 'bookings'){

    echo "<h3>📅 Active Bookings</h3><table>
    <tr>
    <th>ID</th><th>User</th><th>Location</th><th>Slot</th>
    <th>From</th><th>To</th><th>Amount</th><th>Vehicle No</th><th>Status</th><th>Action</th>
    </tr>";

    $bookings = mysqli_query($conn,"SELECT * FROM bookings WHERE status='Booked' ORDER BY id DESC");

    while($row = mysqli_fetch_assoc($bookings)){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['user_id']}</td>
        <td>{$row['location']}</td>
        <td>{$row['slot_number']}</td>
        <td>{$row['from_date']}</td>
        <td>{$row['to_date']}</td>
        <td>₹{$row['amount']}</td>
         <td>{$row['vehicle_no']}</td>
        <td>{$row['status']}</td>
        
        <td>
       <a class='cancel-btn'
href='cancel_booking.php?id={$row['id']}'
onclick=\"return confirm('Cancel this booking?')\">
Cancel
</a>
        </td>
        </tr>";
    }

    echo "</table>";
}

?>

</div>
</div>

</body>
</html>