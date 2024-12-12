<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin.php");
    exit;
}


$stmt = $pdo->prepare("SELECT username, email, role FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();


if (!$user) {
    header("Location: admin.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    if (empty($username) || empty($email)) {
        $error = "Все поля обязательны для заполнения.";
    }

    // Проверка формата email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Неверный формат email.";
    }

    
    if (!isset($error)) {
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'role' => $role,
            'id' => $id
        ]);

        
        header("Location: admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Редактировать пользователя</h1>
    </header>
    <div class="container">
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="admin_edit_user.php?id=<?= $id; ?>" method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label for="role">Роль:</label>
            <select id="role" name="role" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Пользователь</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Администратор</option>
            </select>
            <br>
            <button type="submit">Сохранить изменения</button>
        </form>
        <br>
        <a href="admin.php">Назад к списку пользователей</a>
    </div>
</body>
</html>
