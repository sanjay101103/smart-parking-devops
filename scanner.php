<!DOCTYPE html>
<html>
<head>
<title>QR Scanner</title>

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
body{
text-align:center;
font-family:Poppins;
background:#0f2027;
color:white;
}

#reader{
width:300px;
margin:auto;
margin-top:50px;
}
</style>
</head>

<body>

<h2>📷 Scan Parking QR</h2>

<div id="reader"></div>

<script>
function onScanSuccess(decodedText) {
    window.location.href = decodedText;
}

new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
}).render(onScanSuccess);
</script>

</body>
</html>