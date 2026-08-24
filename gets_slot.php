<?php
$conn = mysqli_connect("localhost","root","","slot_booking");

$sql = "SELECT * FROM slots";
$result = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
?>