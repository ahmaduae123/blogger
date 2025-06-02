<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

// Fetch post
$stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.author_id = users.id WHERE posts.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}

// Fetch comments
$stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, username, comment) VALUES (?, ?, ?)");
    $stmt->execute([$id, $username, $comment]);

    echo "<script>alert('Comment Added!'); window.location.href='view.php?id=$id';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <style>
        body {font-family: Arial; background: #f4f4f4; padding: 20px;}
        .post {background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;}
        .comments {background: white; padding: 20px; border-radius: 5px;}
        input, textarea {width: 100%; padding: 8px; margin-top: 10px;}
        button {padding: 8px 15px; background: #333; color: white; border: none; margin-top: 10px;}
    </style>
</head>
<body>

<div class="post">
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><?= nl2br($post['content']) ?></p>
    <small>By <?= htmlspecialchars($post['username']) ?> on <?= date('d M Y', strtotime($post['created_at'])) ?></small>
</div>

<div class="comments">
    <h2>Comments</h2>
    <?php foreach ($comments as $comment): ?>
        <p><strong><?= htmlspecialchars($comment['username']) ?></strong>: <?= htmlspecialchars($comment['comment']) ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Your Name" required>
        <textarea name="comment" placeholder="Write a comment..." rows="4" required></textarea>
        <button type="submit">Add Comment</button>
    </form>
</div>

</body>
</html>
