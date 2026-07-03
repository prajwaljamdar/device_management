<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
header("Location: login.php");
exit();
}

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$sql = "SELECT * FROM devices";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<div class="container mt-5">

<h1 class="mb-4">⚙️ Admin Dashboard</h1>

<a href="active_sessions.php" class="btn btn-warning mb-3">Active Sessions</a>

<a href="view_users.php" class="btn btn-info mb-3">View Users</a>

<a href="logout.php" class="btn btn-danger mb-3">Logout</a>

<hr>

<h3>Add Device</h3>

<form method="POST" action="add_device.php" class="mb-4">

<div class="input-group">

<input type="text" name="device_name" class="form-control" placeholder="Enter Device Name" required>

<button class="btn btn-success">Add Device</button>

</div>

</form>

<h3>Device List</h3>

<table class="table table-dark table-striped">

<tr>

<th>ID</th>
<th>Device Name</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php
while($row = $result->fetch_assoc())
{
echo "<tr>";

echo "<td>".$row['id']."</td>";

echo "<td>".$row['device_name']."</td>";

echo "<td>".$row['status']."</td>";

echo "<td>
<a href='delete_device.php?id=".$row['id']."' class='btn btn-sm btn-danger'>Delete</a>
</td>";

echo "</tr>";
}
?>

</table>

</div>

</body>
</html>
