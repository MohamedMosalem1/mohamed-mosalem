<?php require 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="form-container">
		<h2>Sign Up</h2>
		<img src="image/user_avatar.png" class="avatar" alt="Avatar">
		<form action="register.php" method="POST">
			<label>Username:</label>
			<input name="username" type="text" placeholder="Enter your username" required />

			<label>Password:</label>
			<input name="password" type="password" placeholder="Enter password" required />

			<label>Confirm Password:</label>
			<input name="password2" type="password" placeholder="Confirm password" required />

			<label>Email:</label>
			<input name="email" type="email" placeholder="Enter your email" required />

			<input name="submit_btn" type="submit" value="Sign Up" />
			<a href="index.php"><input type="button" value="Back to Login" /></a>
		</form>

		<?php
		if (isset($_POST['submit_btn'])) {
			$username = trim($_POST['username']);
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$email = trim($_POST['email']);

			if ($password !== $password2) {
				echo '<script>alert("Passwords do not match!");</script>';
			} else {
				$stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
				$stmt->execute([$username]);

				if ($stmt->rowCount() > 0) {
					echo '<script>alert("User already exists. Try another username.");</script>';
				} else {
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
					$stmt = $con->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
					if ($stmt->execute([$username, $email, $hashedPassword])) {
						echo '<script>alert("User Registered Successfully!");</script>';
					} else {
						echo '<script>alert("Registration failed. Please try again.");</script>';
					}
				}
				$stmt->closeCursor();
			}
		}
		?>
	</div>
</body>
</html>
