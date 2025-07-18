<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Add New Entry</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="form-container">
		<img src="image/bot_avatar.png" alt="Bot Avatar" class="avatar">
		<h2>Add Question & Reply</h2>
		<form method="POST">
			<label for="question">Question</label>
			<input type="text" name="question" placeholder="Type your question..." required>

			<label for="reply">Reply</label>
			<input type="text" name="reply" placeholder="Type your reply..." required>

			<input type="submit" name="submit" value="Add to Dataset">
		</form>
	</div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
	$question = htmlspecialchars($_POST['question']);
	$reply = htmlspecialchars($_POST['reply']);

	try {
		$stmt = $con->prepare("INSERT INTO chatbot_hints (question, reply) VALUES (?, ?)");
		$insert = $stmt->execute([$question, $reply]);

		if ($insert) {
			echo '<script>alert("Entry added successfully!"); window.location.href="qna.php";</script>';
		} else {
			echo '<script>alert("Failed to insert entry.");</script>';
		}
		$stmt->closeCursor();
	} catch (PDOException $e) {
		echo '<script>alert("Database Error: ' . htmlspecialchars($e->getMessage()) . '");</script>';
	}
}
?>
