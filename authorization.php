<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        include('dbconnect.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <link rel="icon" href="extra/files/logo.ico" type="image/x-icon">
    <title>Авторизация</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="extra/files/logo.svg" alt="" srcset=""></a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Поиск</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="authorization.php">Войти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <section class="vh-100">
            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-6 text-black">
                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                        <form style="width: 23rem;" method="POST" action="">
                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Войти в аккаунт</h3>
                            <div class="form-outline mb-4">
                                <input type="text" name="login" class="form-control form-control-lg" />
                                <label class="form-label">Логин</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" name="password" class="form-control form-control-lg" />
                                <label class="form-label">Пароль</label>
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block" name="auth" type="submit">Войти</button>
                            </div>
                            
                            <p><a href="signup.php" class="link-primary">Зарегистрироваться</a></p>
                        </form>
                    </div>
                        <?php
                            if (isset($_POST["auth"])) {
                                $login = $_POST["login"];
                                $password = md5($_POST["password"]);

                                $stmt = mysqli_prepare($mysql, "SELECT id FROM users WHERE login = ? AND password = ?");
                                $stmt->bind_param('ss', $login, $password);
                                mysqli_stmt_execute($stmt);
                                $stmt->store_result();

                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($id);
                                    $stmt->fetch();
                                    session_start();
                                    $_SESSION["user_id"] = $id;
                                    $stmt->close();
                                    header("Location: personal.php");
                                }
                                else {
                                    echo "<p>Введены некорректные данные.</p>";
                                }

                                $stmt->close();
                            }
                                
                        ?>

                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="extra/files/curvy-road-in-mountain-landscape.jpg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="container">
            <div class="row">
                <div class="col-6 text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    Использованные источники:<br>
                    <span class="copyright"><a target="blank_" href="https://ru.freepik.com/free-photo/curvy-road-in-mountain-landscape_12040258.htm">Изображение от wirestock</a> на Freepik</span>
                </div>
                <div class="col-6 text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    Веб-сервис разработан студентом Московского Политеха<br>
                    Москва, 2024
                </div>
            </div>
        </div>        
    </footer>
</body>
</html>