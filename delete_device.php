<?php

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$id = $_GET['id'];

$sql = "DELETE FROM devices WHERE id=$id";

$conn->query($sql);

header("Location: admin_dashboard.php");

?>
