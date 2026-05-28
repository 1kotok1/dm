<?php

session_start();
require 'db.php';

$login = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($login == '' || $password == '') {
        $errors[] = 'Введите все данные';
    }

    if ($login == 'Admin' && $password == 'KorokNET') {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    }

    if (count($errors) == 0) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?');
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Неправильный логин или пароль';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header('Location: app.php');
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Главная страница</title>
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
                    <input type="text" name='login' placeholder="  Логин" required>
                    <input type="password" name='password' placeholder="  Пароль" required>
                    <button type="submit">Авторизоваться</button>
                    <a href="registration.php">У меня нет учетной записи</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>