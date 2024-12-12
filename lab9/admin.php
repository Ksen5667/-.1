<?php
session_start();
include 'db.php';

// Проверка, является ли пользователь администратором
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Получение всех пользователей
$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users");
$users = $stmt->fetchAll();

// Удаление пользователя
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $deleteId]);
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Админ-панель: управление пользователями</h1>
    </header>
    <div class="container">
        <a href="admin_add_user.php" class="add-link">Добавить нового пользователя</a>
        <h2>Список пользователей</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя пользователя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <?= htmlspecialchars($user['role']) === 'admin' ? 'Администратор' : 'Пользователь'; ?>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <a href="admin_edit_user.php?id=<?= $user['id']; ?>">Редактировать</a>
                            <a href="admin.php?delete_id=<?= $user['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
        <br>
        <a href="main.php">На главную</a>
    </div>
    <footer>
        &copy; 2024 Театральный сайт. Все права защищены.
    </footer>
</body>
</html>


