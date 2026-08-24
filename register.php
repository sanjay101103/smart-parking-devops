<?php
include 'config.php';
if(isset($_POST['register'])){
$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

$conn->query("INSERT INTO users(name,email,phone,password) VALUES('$name','$email','$phone','$password')");
echo "<script>alert('Registered Successfully');window.location='login.php';</script>";
}
?>

<html>
<head>
<style>
body{background:#2a5298;color:white;font-family:Arial;text-align:center;padding-top:80px;}
input{padding:10px;width:250px;margin:5px;border-radius:6px;border:none;}
button{padding:10px 20px;background:#ffc107;border:none;border-radius:8px;font-weight:bold;}
</style>
</head>
<body>
<h2>Register</h2>
<form method="post">
<input type="text" name="name" placeholder="Name" required><br>
<input type="email" name="email" placeholder="Email" required><br>
<input type="text" name="phone" placeholder="Phone" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button name="register">Register</button>
</form>
</body>
</html>
