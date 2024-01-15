<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        // include('dbconnect.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ЛОГОТИП</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="authorization.php">Войти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        
        <form method="POST" action="auth.php">
            <label>Логин</label>
            <input type="text" name="login">
            
            <label>Пароль</label>
            <input type="password" name="password">
        
            <label></label>
            <button type="submit">Войти</button>
            <a href="signup.php">Регистрация</a>
        </form>
    </main>
</body>
</html>