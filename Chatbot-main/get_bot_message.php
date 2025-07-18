<?php
date_default_timezone_set('Africa/Cairo');
require_once 'config.php';

$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['txt'])) {
    $user_msg = $_POST['txt'];
    $stmt = $con->prepare("SELECT * FROM chatbot_hints WHERE question LIKE ?");
    $stmt->execute(["%$user_msg%"]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $content = $row['reply'];
    } else {
        $content = "❓ Sorry, I couldn't understand you.";
    }

    $stmt->closeCursor();
    $added_on = date('Y-m-d H:i:s');

    // Insert both messages
    $con->prepare("INSERT INTO message(message, added_on, type) VALUES(?, ?, ?)")->execute([$user_msg, $added_on, 'user']);
    $con->prepare("INSERT INTO message(message, added_on, type) VALUES(?, ?, ?)")->execute([$content, $added_on, 'bot']);

    $response = $content;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ARESA Chatbot</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="chat-container">
        <h2>🤖 ARESA Chatbot</h2>
        <div class="chat-box">
            <?php if (!empty($user_msg)): ?>
                <p><strong>User:</strong> <?= htmlspecialchars($user_msg) ?></p>
                <p><strong>Bot:</strong> <?= htmlspecialchars($response) ?></p>
            <?php else: ?>
                <p>Start the conversation below...</p>
            <?php endif; ?>
        </div>

        <form action="" method="POST">
            <input type="text" name="txt" placeholder="Type your message..." required>
            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>
