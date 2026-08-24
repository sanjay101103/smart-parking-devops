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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<title>Book Slot - Parking Slot Booking</title>

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
backdrop-filter:blur(8px);
padding:15px 30px;
display:flex;
justify-content:center;
position:relative;
font-size:22px;
font-weight:bold;
}

.back-btn{
position:absolute;
left:20px;
background:linear-gradient(45deg,#ff416c,#ff4b2b);
color:white;
padding:8px 15px;
border-radius:20px;
text-decoration:none;
}

/* CONTAINER */
.container{
display:flex;
justify-content:center;
align-items:flex-start; 
min-height:90vh;
padding-top:35px; 
}

/* BOX */
.booking-box{
background:rgba(255,255,255,0.15);
padding:40px;
border-radius:20px;
width:400px;
text-align:center;
box-shadow:0 10px 30px rgba(0,0,0,0.6);

}

/* FORM ALIGN */
.booking-box form{
display:flex;
flex-direction:column;
gap:5px;
}

/* INPUT STYLE */
select, input{
width:100%;
padding:14px;
margin:10px 0;
border-radius:10px;
border:1px solid rgba(255,255,255,0.3);
background:rgba(255,255,255,0.2);
color:white;
font-size:15px;
box-sizing:border-box;
outline:none;
}

/* FOCUS EFFECT */
select:focus, input:focus{
border:1px solid #00dbde;
box-shadow:0 0 5px #00dbde;
}

/* PLACEHOLDER */
::placeholder{
color:rgba(255,255,255,0.7);
}

input[readonly]{
background:rgba(0,255,200,0.25);
font-weight:bold;
}

/* BUTTON */
button{
width:100%;
padding:14px;
margin-top:10px;
background:linear-gradient(45deg,#00dbde,#fc00ff);
color:white;
border:none;
border-radius:25px;
cursor:pointer;
font-size:16px;
transition:0.3s;
}

button:hover{
transform:scale(1.05);
}

select option{
color:black;
}

h2{
margin-bottom:20px;
}
</style>

<script>
function setMinDate(){
    var today = new Date().toISOString().split("T")[0];
    document.getElementById("from_date").min = today;
    document.getElementById("to_date").min = today;
}

function calculateAmount(){

    var fd = document.getElementById("from_date").value;
    var ft = document.getElementById("from_time").value;
    var td = document.getElementById("to_date").value;
    var tt = document.getElementById("to_time").value;

    if(fd && ft && td && tt){

        var start = new Date(fd + "T" + ft);
        var end = new Date(td + "T" + tt);

        if(end <= start){
            alert("⚠ Invalid time");
            document.getElementById("days").value="";
            document.getElementById("amount").value="";
            return;
        }

        var hours = (end - start)/(1000*60*60);
        var days = Math.ceil(hours/24);

        document.getElementById("days").value = days;
        document.getElementById("amount").value = days * 500;
    }
}

function validateForm(){
    var days = document.getElementById("days").value;
    var amount = document.getElementById("amount").value;

    if(days == "" || amount == ""){
        alert("⚠ Please select valid date & time");
        return false;
    }
    return true;
}

window.onload = setMinDate;
</script>

</head>

<body>

<div class="header">
<a href="viewslot.php" class="back-btn">⬅ Back</a>
🚗 Parking Slot Booking
</div>

<div class="container">
<div class="booking-box">

<h2>Book Parking Slot</h2>

<form method="post" action="payment.php" onsubmit="return validateForm()">

<!-- LOCATION -->
<select name="location" required>
<option value="" disabled selected>Select Location</option>

<option value="Railway Station">Chidambaram</option>
</select>

<!-- SLOT -->
<select name="slot_id" required>
<option value="">Select Available Slot</option>

<?php
$slots = $conn->query("SELECT * FROM slots WHERE status='Available'");
while($row = $slots->fetch_assoc()){
echo "<option value='".$row['id']."'>".$row['slot_number']." - ".$row['location']."</option>";
}
?>
</select>

<input type="text" name="vehicle_no" placeholder="Vehicle Number" required>


<!-- DATE & TIME -->
<input type="date" name="from_date" id="from_date" onchange="calculateAmount()" required>
<input type="time" name="from_time" id="from_time" onchange="calculateAmount()" required>

<input type="date" name="to_date" id="to_date" onchange="calculateAmount()" required>
<input type="time" name="to_time" id="to_time" onchange="calculateAmount()" required>

<!-- RESULT -->
<input type="text" name="days" id="days" placeholder="Days" readonly>
<input type="text" name="amount" id="amount" placeholder="Amount ₹" readonly>

<button type="submit">Proceed to Payment</button>

</form>

</div>
</div>

</body>
</html>