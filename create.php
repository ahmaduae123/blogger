<?php
include 'db.php';

// Hardcoded author (because no login system yet)
$author_id = 1; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, author_id, category) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $content, $author_id, $category]);

    echo "<script>alert('Post Created Successfully!'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <style>
        body {font-family: Arial; background: #f4f4f4; padding: 20px;}
        form {background: white; padding: 20px; border-radius: 5px;}
        input, textarea, select {width: 100%; padding: 10px; margin-bottom: 10px;}
        button {padding: 10px 15px; background: #333; color: white; border: none;}
    </style>
</head>
<body>

<form method="POST">
    <h2>Create a New Blog Post</h2>
    <input type="text" name="title" placeholder="Post Title" required>
    <textarea name="content" placeholder="Write your post here..." rows="10" required></textarea>
    <select name="category">
        <option value="Technology">Technology</option>
        <option value="Lifestyle">Lifestyle</option>
        <option value="Business">Business</option>
        <option value="Travel">Travel</option>
    </select>
    <button type="submit">Publish</button>
</form>

</body>
</html>
