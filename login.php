<?php
session_start();

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

if(isset($_POST['login']))
{
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if($result->num_rows > 0)
{
$row = $result->fetch_assoc();

$_SESSION['user'] = $email;
$_SESSION['role'] = $row['role'];

if($row['role'] == 'admin')
{
header("Location: admin_dashboard.php");
}
else
{
header("Location: dashboard.php");
}

exit();
}
else
{
echo "Invalid Email or Password";
}

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Device Manager</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4" style="width:350px">

<h3 class="text-center mb-4">Device Manager</h3>

<form method="POST">

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="login" class="btn btn-primary w-100">Login</button>

</form>

<p class="text-center mt-3">
<a href="signup.php">Create Account</a>
</p>

</div>

</body>
</html>
