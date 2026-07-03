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

/* Check if this user owns the session */

$check = $conn->query("SELECT * FROM device_sessions 
WHERE device_id='$device_id' 
AND user_email='$user' 
AND end_time IS NULL");

if($check->num_rows == 0)
{
echo "You cannot stop this session.";
exit();
}

/* Stop session */

$conn->query("UPDATE devices 
SET status='available' 
WHERE id='$device_id'");

$conn->query("UPDATE device_sessions 
SET end_time = NOW() 
WHERE device_id='$device_id' 
AND user_email='$user' 
AND end_time IS NULL");

header("Location: dashboard.php");
exit();
?>
