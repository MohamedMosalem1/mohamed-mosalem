<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Report Invalid Response</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Fonts + Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="report-container">
		<img src="image/bot_avatar.png" alt="Bot Avatar">
		<h2>Report Invalid Answer</h2>
		<form method="POST">
			<input type="text" name="messages" placeholder="Type the invalid response..." required>
			<input type="submit" name="submit" value="Report as Invalid">
		</form>
	</div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
	$messages = $_POST['messages'];
	try {
		$stmt = $con->prepare("INSERT INTO invalid(messages) VALUES(?)");
		if ($stmt->execute([$messages])) {
			echo '<script>alert("Response reported successfully!");</script>';
		} else {
			echo '<script>alert("Failed to report. Please try again.");</script>';
		}
		$stmt->closeCursor();
	} catch (PDOException $e) {
		echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
	}
}
?>
