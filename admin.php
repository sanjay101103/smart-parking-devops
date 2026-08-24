<?php include 'config.php'; ?>


<html>
<head>
<style>
body{background:#000;color:white;font-family:Arial;text-align:center;padding-top:40px;}
</style>
</head>
<body>

<h2>Admin Panel</h2>

<h3>Users</h3>
<?php
$users=$conn->query("SELECT * FROM users WHERE role='user'");
while($u=$users->fetch_assoc()){
echo $u['name']." - ".$u['email']."<br>";
}
?>

<h3>Bookings</h3>
<?php
$book=$conn->query("SELECT * FROM bookings");
while($b=$book->fetch_assoc()){
echo "Booking ID: ".$b['id']." - Status: ".$b['status']."<br>";
}
?>

<a href="logout.php">Logout</a>

</body>
</html>
