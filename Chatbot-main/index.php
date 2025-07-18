<?php
session_start();
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<div id="main-wrapper">
		<h2><strong id="log">Login</strong></h2>
		<form class="myform" action="" method="post">
			<div class="inner_container">
				<label for="us">Username:</label>
				<input name="username" id="us" type="text" class="inputvalues" placeholder="Enter Username..." required />

				<label for="pass">Password:</label>
				<input name="password" id="pass" type="password" class="inputvalues" placeholder="Enter Password..." required />

				<input name="login" type="submit" id="login_btn" value="Login" />

				<a href="register.php"><input type="button" id="register_btn" value="Register" /></a>
				<a href="admin.php"><input type="button" id="admin_btn" value="Login as Admin" /></a>
			</div>
		</form>

		<?php
		if (isset($_POST['login'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->execute([$username]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($user) {
				if ( $password == $user['password'] ) {
				$_SESSION['username'] = $username;
				header('Location: homepage.php');
				exit();
				}
			} else {
				echo '<script>alert("Invalid username or password!")</script>';
			}
		}
		?>
	</div>

</body>
</html>
