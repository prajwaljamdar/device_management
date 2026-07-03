<?php

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$name = $_POST['device_name'];

$sql = "INSERT INTO devices (device_name,status) VALUES ('$name','available')";

$conn->query($sql);

header("Location: admin_dashboard.php");

?>
