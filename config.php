<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'slot_booking';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) { http_response_code(500); die("Database Connection Failed"); }
if (session_status() === PHP_SESSION_NONE) { session_start(); }
define("TWILIO_SID", getenv('TWILIO_SID') ?: '');
define("TWILIO_TOKEN", getenv('TWILIO_TOKEN') ?: '');
define("TWILIO_FROM", getenv('TWILIO_FROM') ?: '');
?>