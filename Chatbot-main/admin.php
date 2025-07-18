<?php 
	session_start();
	require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Icons (اختياري) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="form-container">
		<img src="image/admin.png" class="avatar" alt="Admin">
		<h2>Login as Admin</h2>

		<form action="adminpage.php" method="post">
			<label for="adminpass">Password:</label>
			<input name="password" type="password" id="adminpass" placeholder="Enter admin password" required />

			<a href="adminlogin.php"><input  type="button" id="admin_btn" value="Log In"/></a><br>
			<a href="index.php"><input type="button" value="Back to Home" /></a>
		</form>
	</div>
</body>
</html>
