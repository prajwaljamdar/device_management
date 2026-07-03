<?php

$conn = new mysqli("localhost","projectuser","Project@123","device_management");

if(isset($_POST['signup']))
{
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')";

if($conn->query($sql))
{
echo "Account Created Successfully";
}
else
{
echo "Error";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Create Account</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4" style="width:350px">

<h3 class="text-center mb-4">Create Account</h3>

<form method="POST">

<input type="text" name="name" class="form-control mb-3" placeholder="Name" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="signup" class="btn btn-success w-100">Signup</button>

</form>

<p class="text-center mt-3">
<a href="login.php">Back to Login</a>
</p>

</div>

</body>
</html>
