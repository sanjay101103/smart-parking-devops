<?php
include 'config.php';


if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Select Slot</title>

<style>
body{
margin:0;
font-family:'Segoe UI';
background:linear-gradient(135deg,#1a1a2e,#16213e);
color:white;
text-align:center;
padding:40px;
}

table{
width:90%;
margin:auto;
border-collapse:collapse;
background:white;
color:black;
}

th{
background:#ff2e63;
color:white;
padding:12px;
}

td{
padding:10px;
border:1px solid #ddd;
}

.available{ background:#28a745; color:white; }
.booked{ background:#dc3545; color:white; }

button{
padding:6px 10px;
border:none;
border-radius:6px;
cursor:pointer;
}
</style>
</head>
<body>

<h2>Select Slot & Time</h2>

<form method="post" action="payment.php">

<label>Select Date:</label><br>
<input type="date" name="date" required><br><br>
<label>From Time:</label><br>

<input type="time" name="from_time" required><br><br>

<label>To Time:</label><br>
<input type="time" name="to_time" required><br><br>

<table>
<tr>
<th>Slot</th>
<th>Location</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM slots");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><?php echo $row['slot_number']; ?></td>
<td><?php echo $row['location']; ?></td>

<td class="<?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</td>

<td>
<?php if($row['status']=="Available"){ ?>
<input type="radio" name="slot_id" value="<?php echo $row['id']; ?>" required>
<?php } else { echo "-"; } ?>
</td>

</tr>

<?php } ?>
</table>

<br>
<button type="submit" style="background:#ffc107;">Proceed to Payment</button>

</form>

</body>
</html>
