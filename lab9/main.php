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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Театральный сайт</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Добро пожаловать в мир театра!</h1>
            <h3>Познакомьтесь с новыми постановками, статьями и новостями о театре</h3>
        </header>

        <!-- Если пользователь вошел, показываем информацию о нем -->
        <?php if ($isLoggedIn): ?>
            <div class="user-info" style="text-align: right; margin-right: 70px;">
                <p>Вы вошли как: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
                <form method="GET" action="profile.php" style="display:inline;">
                    <button type="submit" class="btn">Профиль</button>
                </form>
                <p>
                    <a href="personal_articles.php" class="btn-link">Мои статьи</a>
                    <?php if ($isAdmin): ?>
                        | <a href="admin.php" class="btn-link">Админ-панель</a>
                    <?php endif; ?>
                </p>

                <?php if (isset($_GET['success'])): ?>
                    <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="auth-links" style="text-align: right; margin-right: 70px;">
                <p><a href="login.php" class="btn-link">Войти</a> | <a href="register.php" class="btn-link">Регистрация</a></p>
            </div>
        <?php endif; ?>
        <hr>

        <!-- Основной контент - статьи -->
        <main>
            <?php foreach ($articles as $article): ?>
                <section class="article">
                    <h2><?= htmlspecialchars($article['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                    <p class="article-date">Опубликовано: <?= $article['created_at'] ?></p>
                </section>
                <hr>
            <?php endforeach; ?>
        </main>

        <!-- Ссылка на рейтинг театров -->
        <section class="external-link">
            <p><a href="https://www.teatr.ru/" target="_blank" class="external-link-btn">Театральные новости</a></p>
        </section>

        <footer>
            &copy; 2024 Театральный сайт. Все права защищены.
        </footer>
    </div>
</body>
</html>


