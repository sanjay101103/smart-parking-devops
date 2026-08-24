<?php
if(isset($_POST['message'])){
    $msg = strtolower($_POST['message']);

    if($msg == "hi" || $msg == "hello"){
        echo "Hello! Welcome to Smart Parking System.";
    }
    elseif(strpos($msg, "parking") !== false){
        echo "Parking available in Area 1 and Area 2.";
    }
    elseif(strpos($msg, "slot") !== false){
        echo "Slots available: A1, A2, B1, B2.";
    }
    elseif(strpos($msg, "price") !== false){
        echo "Parking price Rs.20 per hour.";
    }
    elseif(strpos($msg, "book") !== false){
        echo "Go to booking page to book your slot.";
    }
    else{
        echo "Ask about parking, slot, price, booking.";
    }
}
?>
<?php
$conn = mysqli_connect("localhost","root","","slot_booking");

if(isset($_POST['message'])){
    $msg = strtolower($_POST['message']);

    if(strpos($msg, "nearest") !== false || strpos($msg, "near parking") !== false){

        $sql = "SELECT * FROM slots WHERE status='Available' LIMIT 3";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            echo "Nearest Available Parking:<br>";
            while($row = mysqli_fetch_assoc($result)){
                echo $row['location'] . " - Slot " . $row['slot_number'] . "<br>";
            }
        } else {
            echo "No parking available.";
        }
    }
    elseif(strpos($msg, "available") !== false){
        $sql = "SELECT COUNT(*) as total FROM slots WHERE status='Available'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        echo "Available slots: " . $row['total'];
    }
    else{
        echo "Ask: nearest parking / available slots";
    }
}
?>