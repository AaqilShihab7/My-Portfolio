<?php
// Database connection
$con = new mysqli("localhost", "root", "", "portfolio");

$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .message-card {
            background: white;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message-card h3 {
            margin: 0 0 10px;
        }
        .message-card p {
            margin: 5px 0;
        }
        .message-card small {
            color: gray;
        }
    </style>
</head>
<body>
    <h1>Messages</h1>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="message-card">
                <h3><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</h3>
                <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                <small>Received on: <?= htmlspecialchars($row['created_at']) ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>
</body>
</html>
