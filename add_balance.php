<?php
session_start();

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

$user = $_SESSION['user'];

if(isset($_POST['amount']))
{
$amount = $_POST['amount'];

$_SESSION['pay_amount'] = $amount;
header("Location: payment_confirm.php");
exit();

header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Balance</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 text-dark" style="width:400px">

<h3 class="text-center mb-3">Add Balance</h3>

<form method="POST">

<label class="form-label">Enter Amount</label>

<input type="number" name="amount" class="form-control mb-3" required>

<label class="form-label">Select Payment Method</label>

<div class="form-check">
<input class="form-check-input" type="radio" name="payment" required>
<label class="form-check-label">UPI</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="payment">
<label class="form-check-label">Debit / Credit Card</label>
</div>

<div class="form-check mb-3">
<input class="form-check-input" type="radio" name="payment">
<label class="form-check-label">Net Banking</label>
</div>

<button class="btn btn-success w-100">Pay Now</button>

</form>

<hr>

<div class="text-center">

<h6>Quick Add</h6>

<form method="POST" class="d-flex justify-content-between">

<button name="amount" value="60" class="btn btn-outline-primary">₹60</button>
<button name="amount" value="120" class="btn btn-outline-primary">₹120</button>
<button name="amount" value="300" class="btn btn-outline-primary">₹300</button>

</form>

</div>

<br>

<a href="dashboard.php" class="btn btn-secondary w-100">Back</a>

</div>

</body>
</html>
