<?php
include 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['role'] === 'admin';

$stmt = $pdo->query("SELECT title, content, created_at FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Театр</title>
    <style>
        p, h2, small {
            text-indent: 15px;
        }
        .header {
            text-align: center;
            font-family: 'Georgia', serif;
            background-color: #2e2b2b;
            color: #f1f1f1;
            padding: 20px;
            font-size: 2em;
        }
        .article {
            background-color: #f8f4f4;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .article h2 {
            font-family: 'Times New Roman', serif;
            font-size: 1.8em;
            color: #9c2b2b;
        }
        .article p {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }
        footer {
            text-align: center;
            background-color: #2e2b2b;
            color: #f1f1f1;
            padding: 10px;
            font-family: 'Georgia', serif;
        }
        a {
            text-decoration: none;
            color: #9c2b2b;
        }
        a:hover {
            color: #c97d7d;
        }
        .nav-links {
            margin-left: 20px;
        }
        .nav-links a {
            margin-right: 15px;
        }
    </style>
</head>
<body>

    <header class="header"> 
        <h1>Добро пожаловать в театр!</h1>
    </header>

    <div style="margin: 0 20px;">
        <?php if ($isLoggedIn): ?>
            <p align="left">Вы вошли как: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
            <p align="left" class="nav-links"><a href="profile.php">Посмотреть данные</a> | <a href="profile_edit.php">Изменить данные</a></p>
            <?php if ($isAdmin): ?>
                <p align="left" class="nav-links"><a href="admin.php">Админ-панель</a></p>
            <?php endif; ?>
            <p align="left" class="nav-links"><a href="logout.php">Выход</a></p>
        <?php else: ?>
            <p align="left" class="nav-links"><a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
        <?php endif; ?>

        <hr>

        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?= htmlspecialchars($article['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                <p style="font-size:12px;">Опубликовано: <?= $article['created_at'] ?></p>
            </div>
            <hr>
        <?php endforeach; ?>

    </div>

    <footer>
        &copy; 2024 Театральный сайт. 
    </footer>
</body>
</html>
