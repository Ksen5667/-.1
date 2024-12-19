<?php
include 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['role'] === 'admin';

$stmt = $pdo->query("SELECT id, title, content, created_at FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Театральный сайт</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f0f0f0;
            color: #333;
            line-height: 1.6;
        }
        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        header h1 {
            font-size: 36px;
            color: #7A3C3C;
            font-family: 'Times New Roman', serif;
        }
        header h3 {
            font-size: 20px;
            color: #555;
        }
        .article {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .article h2 {
            font-size: 28px;
            color: #7A3C3C;
        }
        .article p {
            font-size: 16px;
            color: #444;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
        a {
            color: #7A3C3C;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-buttons a {
            background-color: #7A3C3C;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .action-buttons a:hover {
            background-color: #5b2b2b;
        }
    </style>
</head>
<body>
<div class="wrapper">
  <header>  
    <h1>Театральный портал</h1>
    <h3>Платформа для просмотра и создания контента о театре</h3> 
  </header>

  <!-- Проверка авторизации -->
  <?php if ($isLoggedIn): ?>
  <div style="text-align: right; margin-right: 70px;">
    <p>Вы вошли как: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
    
    <form method="GET" action="profile.php" style="display:inline;">
        <button type="submit" style="background-color: #7A3C3C; color: #fff; padding: 15px; border-radius: 5px; cursor: pointer;margin-right: 10px;">
            Профиль
        </button>
    </form>
    
    <p>
        <a href="personal_articles.php">Мои статьи</a>
        <?php if ($isAdmin): ?>
            | <a href="admin.php">Админ-панель</a>
        <?php endif; ?>
    </p>
   
    <!-- Вывод успешного сообщения после редактирования статьи -->
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
  </div>
  <?php else: ?>
  <div style="text-align: right;margin-right: 70px;">
    <p> <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
  </div>
  <?php endif; ?>  

  <hr>

  <!-- Вывод списка театральных статей -->
  <?php foreach ($articles as $article): ?>
    <div class="article">
        <h2><?= htmlspecialchars($article['title']) ?></h2>
        <!-- Превью контента (ограничиваем длину контента) -->
        <p><?= nl2br(htmlspecialchars(mb_substr($article['content'], 0, 300))) ?>...</p>
        
        <!-- Форматирование даты -->
        <?php
        $date = new DateTime($article['created_at']);
        $formattedDate = $date->format('d.m.Y H:i');
        ?>
        <p style="font-size: 12px;">Опубликовано: <?= $formattedDate ?></p>

        <!-- Ссылки для редактирования и удаления -->
        <div class="action-buttons">
            <a href="edit_article.php?id=<?= $article['id'] ?>">Редактировать</a> | 
            <a href="delete_article.php?id=<?= $article['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить эту статью?');">Удалить</a>
        </div>
    </div>
    <hr>
  <?php endforeach; ?>

  <p style="text-indent: 70px"><a href="https://www.sports.ru/betting/ratings/">Рейтинг театров и спектаклей</a></p>

  <footer>
        &copy; 2024 Театральный сайт. 
  </footer>
</div>
</body>
</html>
