<?php
include 'db.php'; 
session_start();


$stmt = $pdo->query("SELECT id, title, description, created_at FROM services ORDER BY created_at DESC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Список услуг</title>
</head>
<body>
<header>
    <h1>Список услуг сайта</h1>
</header>

<div class="container">
    <?php foreach ($services as $service): ?>
        <div class="service">
            <h2><?= htmlspecialchars($service['title']) ?></h2>
            <p><?= nl2br(htmlspecialchars($service['description'])) ?></p>
            <p style="font-size: 12px;">Добавлено: <?= $service['created_at'] ?></p>
        </div>
        <hr>
    <?php endforeach; ?>

    <p><a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
</div>

<footer>
    &copy; 2024 Театральная сайт
</footer>

</body>
</html>
