<?php
include 'db.php';

// Fetch posts
$search = $_GET['search'] ?? '';
$query = "SELECT posts.*, users.username FROM posts 
          JOIN users ON posts.author_id = users.id
          WHERE posts.title LIKE :search 
          ORDER BY posts.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Blogger Clone</title>
    <style>
        body {font-family: Arial; margin: 0; padding: 0; background: #f4f4f4;}
        header {background: #333; color: white; padding: 10px 20px;}
        nav a {color: white; margin-right: 15px; text-decoration: none;}
        .container {padding: 20px;}
        .post {background: white; margin-bottom: 15px; padding: 15px; border-radius: 5px;}
        .search-box {margin-bottom: 20px;}
        input[type="text"] {padding: 8px; width: 300px;}
        button {padding: 8px 12px; background: #333; color: white; border: none;}
    </style>
</head>
<body>
<header>
    <nav>
        <a href="index.php">Home</a>
        <a href="create.php">Create Post</a>
    </nav>
</header>

<div class="container">
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2><a href="view.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
            <p><?= substr(strip_tags($post['content']), 0, 150) ?>...</p>
            <small>By <?= htmlspecialchars($post['username']) ?> | <?= date('d M Y', strtotime($post['created_at'])) ?></small>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
