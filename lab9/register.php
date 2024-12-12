<?php
include 'db.php';
session_start();

$successMessage = $errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {
        $errorMessage = "Все поля обязательны для заполнения.";
    } elseif ($password !== $passwordConfirm) {
        // Проверка на совпадение паролей
        $errorMessage = "Пароли не совпадают.";
    } else {
        // Проверка, существует ли уже пользователь с таким email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errorMessage = "Пользователь с таким email уже существует.";
        } else {
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
                $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'email' => $email]);

                
                $userId = $pdo->lastInsertId();

                
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'user';

                
                header("Location: main.php");
                exit;
            } catch (PDOException $e) {
                $errorMessage = "Ошибка регистрации: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Регистрация</h1></header>
    <div class="container">
        <?php if ($errorMessage): ?>
            <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <div>
            <p><a href="login.php">Войти</a></p>
            <p><a href="main.php">Назад</a></p>
        </div>
    </div>
</body>
</html>
