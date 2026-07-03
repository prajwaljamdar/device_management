<?php
session_start();

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

if(!isset($_SESSION['user']))
{
header("Location: login.php");
exit();
}

$user = $_SESSION['user'];
$device_id = $_GET['id'];

/* Check if user already has an active session */

$check = $conn->query("SELECT * FROM device_sessions 
WHERE user_email='$user' 
AND end_time IS NULL");

if($check->num_rows > 0)
{
echo "<h3>You are already using another device!</h3>";
echo "<a href='dashboard.php'>Go Back</a>";
exit();
}

/* Check wallet balance */

$wallet = $conn->query("SELECT wallet FROM users WHERE email='$user'")
->fetch_assoc()['wallet'];

if($wallet < 60)
{
echo "<h3>Insufficient Wallet Balance</h3>";
echo "<a href='add_balance.php'>Add Balance</a>";
exit();
}

/* Deduct wallet */

$conn->query("UPDATE users 
SET wallet = wallet - 60 
WHERE email='$user'");

/* Start device */

$conn->query("UPDATE devices 
SET status='in_use' 
WHERE id='$device_id'");

/* Create session */

$conn->query("INSERT INTO device_sessions (user_email, device_id)
VALUES ('$user','$device_id')");

header("Location: dashboard.php");
exit();
?>
