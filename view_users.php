<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
header("Location: login.php");
exit();
}

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
<title>View Users</title>
</head>

<body>

<h1>Registered Users</h1>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
</tr>

<?php
while($row = $result->fetch_assoc())
{
echo "<tr>";

echo "<td>".$row['id']."</td>";
echo "<td>".$row['name']."</td>";
echo "<td>".$row['email']."</td>";
echo "<td>".$row['role']."</td>";

echo "</tr>";
}
?>

</table>

<br>

<a href="admin_dashboard.php">Back</a>

</body>
</html>
