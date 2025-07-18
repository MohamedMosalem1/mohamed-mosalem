<?php
session_start();
date_default_timezone_set('Africa/Cairo');
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Aresa Chatbot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>

	<div class="chat-container">
		<form action="homepage.php" method="post">
			<input name="logout" type="submit" id="logout_btn" value="Log Out" />
		</form>

		<?php
		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:index.php');
			exit();
		}
		?>

		<div class="card">
			<div class="card-body messages-box">
				<ul class="messages-list">
					<?php
					$stmt = $con->prepare("SELECT * FROM message");
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$message = htmlspecialchars($row['message']);
							$added_on = $row['added_on'];
							$time = date('h:i A', strtotime($added_on));
							$type = $row['type'];

							$class = ($type == 'user') ? 'messages-me' : 'messages-you';
							$img = ($type == 'user') ? 'user_avatar.png' : 'bot_avatar.png';
							$name = ($type == 'user') ? 'Me' : 'Chatbot';

							echo '<li class="' . $class . '">
								<span class="message-img"><img src="image/' . $img . '"></span>
								<div class="message-body">
									<div class="message-header">
										<strong>' . $name . '</strong>
										<small>' . $time . '</small>
									</div>
									<p>' . $message . '</p>
								</div>
							</li>';
						}
					} else {
						echo '<li class="messages-you clearfix start_chat">Please start</li>';
					}
					?>
				</ul>
			</div>

			<div class="card-footer p-0">
				<div class="input-group">
					<input id="input-me" type="text" name="messages" class="form-control" placeholder="Type your message..." />
					<div class="input-group-append">
						<button class="btn" onclick="send_msg()">Send</button>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script>
		function getCurrentTime() {
			const now = new Date();
			let hours = now.getHours();
			let minutes = now.getMinutes();
			const ampm = hours >= 12 ? 'PM' : 'AM';
			hours = hours % 12 || 12;
			minutes = minutes < 10 ? '0' + minutes : minutes;
			return hours + ':' + minutes + ' ' + ampm;
		}

		function send_msg() {
			$('.start_chat').hide();
			const txt = $('#input-me').val();
			if (!txt.trim()) return;

			const htmlUser = `
				<li class="messages-me">
					<span class="message-img"><img src="image/user_avatar.png"></span>
					<div class="message-body">
						<div class="message-header">
							<strong>Me</strong><small>${getCurrentTime()}</small>
						</div>
						<p>${txt}</p>
					</div>
				</li>`;
			$('.messages-list').append(htmlUser);
			$('#input-me').val('');

			$.ajax({
				url: 'get_bot_message.php',
				type: 'POST',
				data: { txt },
				success: function (response) {
					const htmlBot = `
						<li class="messages-you">
							<span class="message-img"><img src="image/bot_avatar.png"></span>
							<div class="message-body">
								<div class="message-header">
									<strong>Chatbot</strong><small>${getCurrentTime()}</small>
								</div>
								<p>${response}</p>
							</div>
						</li>
						<a href="invalidans.php" id="invalid_btn">Invalid Answer ?</a>`;
					$('.messages-list').append(htmlBot);
					$('.messages-box').scrollTop($('.messages-box')[0].scrollHeight);
				}
			});
		}
	</script>
</body>

</html>
