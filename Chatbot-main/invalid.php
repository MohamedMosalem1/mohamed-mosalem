<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Invalid Queries - Admin Portal</title>
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
	</header>

	<h2>Invalid Queries</h2>

	<table>
		<tr>
			<th>ID</th>
			<th>Invalid Query / Response</th>
		</tr>

		<?php
		try {
			$stmt = $con->prepare("SELECT * FROM invalid ORDER BY id DESC");
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$id = htmlspecialchars($row["id"]);
					$message = htmlspecialchars($row["messages"]);
					echo "<tr><td>$id</td><td>$message</td></tr>";
				}
			} else {
				echo "<tr><td colspan='2'>No Record Found</td></tr>";
			}
			$stmt->closeCursor();
		} catch (PDOException $e) {
			echo "<tr><td colspan='2'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
		}
		?>
	</table>

</body>
</html>
