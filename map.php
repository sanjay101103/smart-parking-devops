<!DOCTYPE html>
<html>
<head>
    <title>Parking Map Search</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
     <style>
        #map {
            height: 400px;
            width: 100%;
        }
        body {
            font-family: Arial;
            text-align: center;
        }
        input {
            padding: 10px;
            width: 250px;
        }
        button {
            padding: 10px;
            background: orange;
            border: none;
            color: white;
        }
    </style>
</head>

<body>

<h2>Search Parking Location</h2>
<input type="text" id="location" placeholder="Enter location">
<button onclick="searchLocation()">Search</button>


<div id="map" style="height: 500px;"></div>

<script>
// Initialize map
var map = L.map('map').setView([11.6643, 78.1460], 13);

// Load map tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

// Search location function
function searchLocation() {
    var location = document.getElementById("location").value;

    fetch("https://nominatim.openstreetmap.org/search?format=json&q=" + location)
    .then(response => response.json())
    .then(data => {
        if(data.length > 0){
            var lat = data[0].lat;
            var lon = data[0].lon;

            map.setView([lat, lon], 15);
            L.marker([lat, lon]).addTo(map)
            .bindPopup("Searched Location").openPopup();
        } else {
            alert("Location not found");
        }
    });
}

// Load parking slots from database
fetch("gets_slot.php")
.then(response => response.json())
.then(data => {

    console.log("Parking Data:", data);

    for(var i = 0; i < data.length; i++) {

        var lat = parseFloat(data[i].latitude);
        var lon = parseFloat(data[i].longitude);

        if(!isNaN(lat) && !isNaN(lon)) {

            var color = data[i].status == "Available" ? "green" : "red";

            L.circleMarker([lat, lon], {
                color: color,
                radius: 8
            }).addTo(map)
         .bindPopup(
    "Location: " + data[i].location +
    "<br>Slot: " + data[i].slot_number +
    "<br>Status: " + data[i].status +
    "<br><a href='https://www.google.com/maps/dir/?api=1&destination=" 
    + lat + "," + lon + "' target='_blank'>Navigate</a>" +
    "<br><a href='booking.php?slot=" + data[i].slot_number + "&location=" + data[i].location + "'>" +
    "<button>Book Now</button></a>"

);
        }
    }

});
</script>

</body>
</html>