<?php require_once 'config.php';
$rn = $_GET['rn'];
$ques = $_GET['ques'];
$rep = $_GET['rep'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Update Entry</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="form-container">
		<img src="image/bot_avatar.png" class="avatar" alt="Bot Avatar" />
		<h2>Update Chat Entry</h2>
		<form method="post">
			<input type="hidden" name="id" value="<?= htmlspecialchars($rn) ?>">

			<label for="question">Question</label>
			<input type="text" name="question" value="<?= htmlspecialchars($ques) ?>" required>

			<label for="reply">Reply</label>
			<input type="text" name="reply" value="<?= htmlspecialchars($rep) ?>" required>

			<input type="submit" name="submit" value="Update Details">
		</form>
	</div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
	$id = $_POST['id'];
	$question = htmlspecialchars($_POST['question']);
	$reply = htmlspecialchars($_POST['reply']);

	try {
		$stmt = $con->prepare("UPDATE chatbot_hints SET question = ?, reply = ? WHERE id = ?");
		$update = $stmt->execute([$question, $reply, $id]);

		if ($update) {
			echo "<script>alert('Record Updated Successfully'); window.location.href='qna.php';</script>";
		} else {
			echo "<script>alert('Failed to Update Record');</script>";
		}
		$stmt->closeCursor();
	} catch (PDOException $e) {
		echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
	}
}
?>
