<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, title, content, created_at FROM articles WHERE author_id = :author_id ORDER BY created_at DESC");
    $stmt->execute(['author_id' => $_SESSION['user_id']]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Произошла ошибка при загрузке статей: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Мои статьи</title>
</head>
<body>
<header><h1>Мои статьи</h1></header>
<div class="container">

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php elseif (count($articles) > 0): ?>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            <p style="font-size: 12px;">Опубликовано: <?= htmlspecialchars($article['created_at']) ?></p>

            <!-- Форма для редактирования статьи -->
            <form method="GET" action="edit_article.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">
                <button type="submit" class="button edit-button">Редактировать</button>
            </form>

            <!-- Форма для удаления статьи -->
            <form method="POST" action="delete_article.php" style="display:inline;">
                <input type="hidden" name="article_id" value="<?= htmlspecialchars($article['id']) ?>">
                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить эту статью?');" class="button delete-button">Удалить</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>У вас пока нет статей.</p>
<?php endif; ?>

<p><a href="create_article.php">Добавить статью</a></p>
<p><a href="main.php">На главную</a></p>

</div>
</body>
</html>
