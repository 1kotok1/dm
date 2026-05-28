<?php
session_start();
require 'db.php';

$full_name = '';
$login = '';
$phone = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($full_name == '' || $login == '' || $phone == '' || $email == '' || $password == '') {
        $errors[] = 'Введите все данные для входа';
    }

    if (!preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phone)) {
        $errors[] = 'Номер телефона должен быть в формате 8(XXX)XXX-XX-XX';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Введите корректную почту';
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?;');
    $stmt->execute([$login]);

    if ($stmt->fetch()) {
        $errors[] = 'Логин занят';
    }

    if (count($errors) == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (full_name, `login`, `password`, phone, email) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$full_name, $login, $hash, $phone, $email]);
        header('Location: login.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Регистрация</title>
</head>
<body>
    <div class="header">

        <div class="left-sidebar">
            <a href="index.php">
                <img src="1233.jpg" alt="">
            </a>
        </div>

        <div class="ssylki">
            <a href="registration.php">
                <b><h3>Зарегистрироваться</h3></b>
            </a>
        </div>
    </div>
    <div class="index">
        
        <div class="main">
            <div class="form">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
                <form action="" method="post">
                    <input type="text" name='full_name' placeholder="  Имя" required>
                    <input type="text" name='login' placeholder="  Логин" required>
                    <input type="password" name='password' placeholder="  Пароль" required>
                    <input type="phone" name='phone' placeholder="  Номер телефона" required>
                    <input type="email" name='email' placeholder="  Почта" required>
                    <button type="submit">Авторизоваться</button>
                    <a href="login.php">У меня есть учетная запись</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>