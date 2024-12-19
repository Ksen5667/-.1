<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, author_id) VALUES (:title, :content, :author_id)");
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'author_id' => $author_id
        ]);

        header("Location: main.php?success=Статья добавлена.");
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Добавить статью</title>
</head>
<body>
<header><h1>Добавить статью</h1></header>
<div class="container">
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" placeholder="Заголовок" required>
    <textarea name="content" placeholder="Содержание статьи" required></textarea><br>
    <button type="submit">Добавить статью</button>
</form>
<p><a href="personal_articles.php">К своим статьям</a></p>
<p><a href="main.php">На главную</a></p></div>
</body>
</html>
