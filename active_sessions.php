<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
header("Location: login.php");
exit();
}

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$sql = "SELECT device_sessions.user_email, devices.device_name, device_sessions.start_time,
TIMESTAMPDIFF(MINUTE, device_sessions.start_time, NOW()) AS running_time
FROM device_sessions
JOIN devices ON device_sessions.device_id = devices.id
WHERE device_sessions.end_time IS NULL";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Active Device Sessions</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<div class="container mt-5">

<h2>Active Device Sessions</h2>

<table class="table table-dark table-striped">

<tr>
<th>User</th>
<th>Device</th>
<th>Start Time</th>
<th>Running Time (Minutes)</th>
</tr>

<?php
while($row = $result->fetch_assoc())
{
echo "<tr>";

echo "<td>".$row['user_email']."</td>";
echo "<td>".$row['device_name']."</td>";
echo "<td>".$row['start_time']."</td>";
echo "<td>".$row['running_time']." min</td>";

echo "</tr>";
}
?>

</table>

<a href="admin_dashboard.php" class="btn btn-secondary">Back</a>

</div>

</body>
</html>
