<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Record</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="box">
    <?php
    if (isset($_GET['rn'])) {
      $id = $_GET['rn'];

      try {
          $stmt = $con->prepare("DELETE FROM chatbot_hints WHERE id = ?");
          if ($stmt->execute([$id])) {
              echo '<div class="message">✅ Record deleted successfully.</div>';
          } else {
              echo '<div class="message" style="color: red;">❌ Failed to delete the record.</div>';
          }
          echo '<a href="qna.php"><button class="btn">Back to Dataset</button></a>';
          $stmt->closeCursor();
      } catch (PDOException $e) {
          echo '<div class="message" style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
          echo '<a href="qna.php"><button class="btn">Back</button></a>';
      }
    } else {
        echo '<div class="message" style="color: yellow;">⚠ Invalid or missing record ID.</div>';
        echo '<a href="qna.php"><button class="btn">Back</button></a>';
    }
    ?>
  </div>
</body>
</html>
