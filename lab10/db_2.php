<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$articleId = $_GET['id'] ?? null;

if (!$articleId) {
    header("Location: main.php?error=Некорректный запрос.");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
$stmt->execute(['id' => $articleId]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: main.php?error=Статья не найдена.");
    exit;
}


$commentsStmt = $pdo->prepare("SELECT c.comment, u.username, c.created_at FROM comments c JOIN users u ON c.user_id = u.id WHERE article_id = :article_id ORDER BY c.created_at DESC");
$commentsStmt->execute(['article_id' => $articleId]);
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);
    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (article_id, user_id, comment) VALUES (:article_id, :user_id, :comment)");
        $stmt->execute([
            'article_id' => $articleId,
            'user_id' => $_SESSION['user_id'],
            'comment' => $comment
        ]);
        header("Location: article.php?id=$articleId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?= htmlspecialchars($article['title']) ?></h1>

    <?php if ($article['image']): ?>
        <img src="<?= htmlspecialchars($article['image']) ?>" alt="Image" style="max-width: 100%; height: auto;">
    <?php endif; ?>
    
    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

    <h3>Комментарии:</h3>
    <?php if (count($comments) > 0): ?>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <strong><?= htmlspecialchars($comment['username']) ?>:</strong>
                    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    <p><em>Опубликовано: <?= $comment['created_at'] ?></em></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет комментариев. Будьте первым, кто оставит комментарий!</p>
    <?php endif; ?>

    <h4>Оставить комментарий:</h4>
    <form method="POST">
        <textarea name="comment" required placeholder="Ваш комментарий"></textarea><br>
        <button type="submit">Отправить</button>
    </form>
</body>
</html>
