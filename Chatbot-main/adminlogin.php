<?php 
	session_start();
	require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Admin Portal</title>
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
	</header>

	<h2>Chat Record</h2>

	<table>
		<tr>
			<th>ID</th>
			<th>Message</th>
			<th>Added On</th>
			<th>Type</th>
		</tr>
		
		<?php
			try {
				$sql = "SELECT * FROM message ORDER BY id DESC";
				$stmt = $con->prepare($sql);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr>
							<td>{$row['id']}</td>
							<td>{$row['message']}</td>
							<td>{$row['added_on']}</td>
							<td>{$row['type']}</td>
						</tr>";
					}
				} else {
					echo '<tr><td colspan="4">No Record Found</td></tr>';
				}
				$stmt->closeCursor();
			} catch (PDOException $e) {
				echo "<tr><td colspan='4'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
			}
		?>
	</table>

</body>
</html>
