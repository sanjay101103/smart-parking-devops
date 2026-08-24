<?php
include 'config.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<title>View Slots - Parking Slot Booking</title>

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
backdrop-filter:blur(10px);
color:white;
padding:15px 30px;
display:flex;
align-items:center;
justify-content:center;
position:relative;
font-size:22px;
font-weight:bold;
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

/* BACK BUTTON */
.back-btn{
position:absolute;
left:20px;
background:linear-gradient(45deg,#ff416c,#ff4b2b);
color:white;
padding:8px 15px;
border-radius:20px;
text-decoration:none;
font-size:14px;
transition:0.3s;
}

.back-btn:hover{
transform:scale(1.05);
}

/* CONTAINER */
.container{
padding:60px 20px;
text-align:center;
}

/* TABLE */
table{
width:85%;
margin:auto;
border-collapse:collapse;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(12px);
border-radius:15px;
overflow:hidden;
box-shadow:0 15px 40px rgba(0,0,0,0.5);
}

/* TABLE HEADER */
th{
background:linear-gradient(45deg,#00dbde,#fc00ff);
color:white;
padding:15px;
font-size:16px;
}

/* TABLE DATA */
td{
padding:12px;
border-bottom:1px solid rgba(255,255,255,0.1);
color:white;
}

/* ROW HOVER */
tr:hover{
background:rgba(255,255,255,0.1);
}

/* STATUS COLORS */
.available{
background:#00c853;
color:white;
font-weight:bold;
border-radius:8px;
padding:5px 10px;
display:inline-block;
}

.booked{
background:#ff1744;
color:white;
font-weight:bold;
border-radius:8px;
padding:5px 10px;
display:inline-block;
}

/* BUTTON */
.book-btn{
display:inline-block;
margin-top:30px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
padding:12px 25px;
border-radius:25px;
color:white;
text-decoration:none;
font-weight:bold;
transition:0.3s;
box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

.book-btn:hover{
transform:scale(1.08);
}

/* RESPONSIVE */
@media(max-width:900px){
table{
width:100%;
font-size:14px;
}

th, td{
padding:10px;
}
}

</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
<a href="dashboard.php" class="back-btn">⬅ Back</a>
🚗 Parking Slot Booking System
</div>

<div class="container">

<h2>All Parking Slots</h2>

<table>
<tr>
<th>Slot</th>
<th>Location</th>
<th>Status</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM slots");

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
?>

<tr>
<td><?php echo htmlspecialchars($row['slot_number']); ?></td>
<td><?php echo htmlspecialchars($row['location']); ?></td>
<td class="<?php echo strtolower($row['status']); ?>">
<?php echo htmlspecialchars($row['status']); ?>
</td>
</tr>

<?php 
    }
} else {
    echo "<tr><td colspan='3'>No slots found</td></tr>";
}
?>

</table>

<a href="booking.php" class="book-btn">Book Slot</a>

</div>

</body>
</html>
