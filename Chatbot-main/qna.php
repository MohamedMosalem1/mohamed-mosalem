<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Admin Portal - Dataset</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>

	<header>
		<h1>AR<span>ESA<span>BOT</span></span></h1>
		<nav>
			<ul>
				<li><a href="adminlogin.php">Chats</a></li>
				<li><a href="qna.php">Dataset</a></li>
				<li><a href="invalid.php">Invalid</a></li>
				<li><a href="index.php">Sign Out</a></li>
			</ul>
		</nav>
		<?php
			if (isset($_POST['logout'])) {
				session_destroy();
				header('location:index.php');
			}
		?>
	</header>

	<h2>Chatbot Dataset</h2>

	<table>
		<tr>
			<th>ID</th>
			<th>Query</th>
			<th>Reply</th>
			<th colspan="2">Operations</th>
		</tr>

		<?php
			$stmt = $con->prepare("SELECT * FROM chatbot_hints ORDER BY id DESC");
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$id = htmlspecialchars($row["id"]);
					$question = htmlspecialchars($row["question"]);
					$reply = htmlspecialchars($row["reply"]);
					echo "<tr>
						<td>$id</td>
						<td>$question</td>
						<td>$reply</td>
						<td><a href='update.php?rn=$id&ques=" . urlencode($question) . "&rep=" . urlencode($reply) . "'>Edit</a></td>
						<td><a href='delete.php?rn=$id' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>
					</tr>";
				}
			} else {
				echo "<tr><td colspan='5'>No Record Found</td></tr>";
			}
			$stmt->closeCursor();
		?>
	</table>

	<a href="insert.php"><input type="button" id="insert_btn" value="Insert / Add New" /></a>

</body>
</html>
