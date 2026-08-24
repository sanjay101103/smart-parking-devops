<?php
$result=$conn->query("SELECT * FROM bookings WHERE status='Active'");
while($row=$result->fetch_assoc()){
$end=strtotime($row['booking_date']." ".$row['booking_time']." +".$row['duration']." minutes");
if(time()>$end){
$conn->query("UPDATE bookings SET status='Expired' WHERE id=".$row['id']);
$conn->query("UPDATE slots SET status='Available' WHERE id=".$row['slot_id']);
}
}
?>
