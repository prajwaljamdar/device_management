<?php
session_start();

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

if(!isset($_SESSION['user']))
{
header("Location: login.php");
exit();
}

/* Device list with session owner + timer */
$sql = "SELECT devices.*, 
device_sessions.user_email AS active_user,
TIMESTAMPDIFF(MINUTE, device_sessions.start_time, NOW()) AS running_time
FROM devices
LEFT JOIN device_sessions 
ON devices.id = device_sessions.device_id 
AND device_sessions.end_time IS NULL";

$result = $conn->query($sql);

/* Dashboard statistics */
$total_devices = $conn->query("SELECT COUNT(*) as total FROM devices")->fetch_assoc()['total'];

$devices_in_use = $conn->query("SELECT COUNT(*) as total FROM devices WHERE status='in_use'")->fetch_assoc()['total'];

$devices_available = $conn->query("SELECT COUNT(*) as total FROM devices WHERE status='available'")->fetch_assoc()['total'];

$active_sessions = $conn->query("SELECT COUNT(*) as total FROM device_sessions WHERE end_time IS NULL")->fetch_assoc()['total'];

/* Wallet */
$user = $_SESSION['user'];
$wallet = $conn->query("SELECT wallet FROM users WHERE email='$user'")
->fetch_assoc()['wallet'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Device Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.sidebar{
height:100vh;
background:#111;
padding-top:20px;
}

.card{
transition:0.3s;
}

.card:hover{
transform:scale(1.05);
box-shadow:0 10px 20px rgba(0,0,0,0.3);
}

.sidebar a{
color:white;
display:block;
padding:10px;
text-decoration:none;
}

.sidebar a:hover{
background:#333;
}

</style>

</head>

<body class="bg-dark text-white">

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-md-2 sidebar">

<h4 class="text-center">Device Manager</h4>

<hr>

<a href="dashboard.php">Dashboard</a>
<a href="active_sessions.php">Active Sessions</a>
<a href="logout.php">Logout</a>

</div>

<!-- Main Content -->

<div class="col-md-10 p-4">

<h2 class="mb-2">Device Dashboard</h2>

<p class="text-light">Welcome <?php echo $_SESSION['user']; ?></p>

<p class="text-warning">
Wallet Balance: ₹<?php echo $wallet; ?>
</p>

<a href="add_balance.php" class="btn btn-success mb-3">Add Balance</a>

<!-- Statistics Cards -->

<div class="row mb-4">

<div class="col-md-3">
<div class="card text-center text-dark">
<div class="card-body">
<h6>🖥 Total Devices</h6>
<h3><?php echo $total_devices; ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center text-dark">
<div class="card-body">
<h6>💻 Devices In Use</h6>
<h3><?php echo $devices_in_use; ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center text-dark">
<div class="card-body">
<h6>🟢 Available Devices</h6>
<h3><?php echo $devices_available; ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center text-dark">
<div class="card-body">
<h6>⏱ Active Sessions</h6>
<h3><?php echo $active_sessions; ?></h3>
</div>
</div>
</div>

</div>

<!-- Device Cards -->

<div class="row">

<?php
while($row = $result->fetch_assoc())
{
?>

<div class="col-md-3 mb-4">

<div class="card text-center shadow text-dark">

<div class="card-body">

<h5><?php echo $row['device_name']; ?></h5>

<p>
Status:
<span class="badge bg-<?php echo ($row['status']=="available") ? "success":"warning"; ?>">
<?php echo $row['status']; ?>
</span>
</p>

<?php
if($row['status']=="in_use" && $row['running_time'] !== null)
{
?>
<p class="text-muted">
Running Time: <?php echo $row['running_time']; ?> minutes
</p>
<?php
}
?>

<?php
$current_user = $_SESSION['user'];

if($row['status']=="available")
{
?>
<a href="start.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Start</a>
<?php
}
else
{
if($row['active_user'] == $current_user)
{
?>
<a href="stop.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Stop</a>
<?php
}
else
{
?>
<button class="btn btn-secondary" disabled>In Use</button>
<?php
}
}
?>

</div>

</div>

</div>

<?php
}
?>

</div>

</div>

</div>

</div>

</body>
</html>
