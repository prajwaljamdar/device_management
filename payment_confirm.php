<?php
session_start();

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

if(!isset($_SESSION['user']))
{
header("Location: login.php");
exit();
}

$user = $_SESSION['user'];

if(!isset($_SESSION['pay_amount']))
{
header("Location: add_balance.php");
exit();
}

$amount = $_SESSION['pay_amount'];

if(isset($_POST['confirm']))
{
$conn->query("UPDATE users SET wallet = wallet + $amount WHERE email='$user'");

unset($_SESSION['pay_amount']);

header("Location: dashboard.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Confirm Payment</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 text-dark" style="width:400px">

<h3 class="text-center mb-3">UPI Payment</h3>

<p class="text-center">Amount: ₹<?php echo $amount; ?></p>

<div class="mb-3">
<label class="form-label">UPI ID</label>
<input type="text" class="form-control" placeholder="example@upi">
</div>

<form method="POST">

<button name="confirm" class="btn btn-success w-100">Confirm Payment</button>

</form>

<br>

<a href="add_balance.php" class="btn btn-secondary w-100">Cancel</a>

</div>

</body>
</html>
