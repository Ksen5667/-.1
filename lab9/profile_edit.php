<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$successMessage = $errorMessage = "";

$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    if ($password !== $passwordConfirm) {
        $errorMessage = "Пароли не совпадают.";
    } else {
        try {
            $updateQuery = "UPDATE users SET username = :username, email = :email";
            $params = ['username' => $username, 'email' => $email, 'id' => $userId];

            if (!empty($password)) {
                $updateQuery .= ", password = :password";
                $params['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $updateQuery .= " WHERE id = :id";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            $_SESSION['username'] = $username;

            $successMessage = "Данные успешно обновлены!";
        } catch (PDOException $e) {
            $errorMessage = "Ошибка обновления: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Изменение данных - Театр</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <header> <h1>Изменение данных - Театр</h1> </header>

    <?php if ($successMessage): ?>
        <p style="color: green; text-align: center"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <p style="color: red; text-align: center"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

<div class="container">

    <form method="POST">
        <label>Имя пользователя:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Электронная почта:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Новый пароль (если нужно):</label>
        <input type="password" name="password">

        <label>Подтвердите новый пароль:</label>
        <input type="password" name="password_confirm">

        <button type="submit">Сохранить изменения</button>
    </form>

    <p><a href="main.php">На главную страницу</a></p>
</div>

<footer>
    &copy; 2024 Театральный сайт.
</footer>
</body>
</html>

