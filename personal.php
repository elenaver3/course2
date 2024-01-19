<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        include('session.php');
        include('dbconnect.php');
        $name = "";
        $login = "";
        $date_reg = "";
        $count_places = "";
        if (isset($session_user) && $session_user != false) {

            $stmt = mysqli_prepare($mysql, "SELECT name, login, DATE_FORMAT(reg_date,'%d.%m.%Y'), IF(COUNT(favourites.id_place) IS NULL, 0, COUNT(favourites.id_place)) FROM users LEFT JOIN favourites ON users.id=favourites.id_user WHERE users.id = ? GROUP BY users.id");
            $stmt->bind_param('s', $session_user);
            mysqli_stmt_execute($stmt);
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_name, $user_login, $date, $count);
                $stmt->fetch();
                $name = $user_name;
                $login = $user_login;
                $date_reg = $date;
                $count_places = $count;
            }

            $stmt->close();
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <link rel="icon" href="extra/files/logo.ico" type="image/x-icon">
    <title>Личный кабинет</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="extra/files/logo.svg" alt="" srcset=""></a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Поиск</a>
                </li>
                <?php
                    if(isset($session_user) && $session_user != false) {
                        echo '<li class="nav-item">
                                <a class="nav-link active" href="personal.php">Личный кабинет</a>
                            </li>';
                        echo '<li class="nav-item">
                                <a class="nav-link" href="logout.php">Выйти</a>
                            </li>';
                    }
                    else {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="authorization.php">Войти</a>
                            </li>';
                    }
                    
                ?>
                
            </ul>
        </div>
    </nav>
    <main>
    <section>
        <div class="container py-5">
            <h1>Личный кабинет</h1>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-sm-3">
                                    <p class="mb-0">Имя</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $name; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Логин</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $login; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Дата регистрации</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $date_reg; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Количество мест в избранном</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $count_places; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h2>Избранное</h2>
            <div class="row">
                <div class="col">
                <?php
                try{
                    if(isset($session_user) && $session_user != false) {

                        try {
                            $stmt = mysqli_prepare($mysql, "SELECT places.id, name, city, street_house FROM places JOIN favourites ON places.id=favourites.id_place WHERE favourites.id_user = ?");
                            $stmt->bind_param('d', $session_user);
                            mysqli_stmt_execute($stmt);

                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($id, $name, $city, $street_house);
                                while ($stmt->fetch()) {
                                    echo '<div class="container p-3 mt-3 mb-3 border border-4 border-black ">
                                        <div class="row">
                                            <div class="col-6">
                                                <h4>'.$name.'</h4>
                                                <p>'.$city.' '.$street_house.'</p>
                                            </div>
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="more" target="_blank" href="place.php?id='.$id.'"><button class="btn btn-outline-primary">Подробнее</button></a>
                                            </div>
                                            <div class="col-3 d-flex justify-content-center">
                                                <form method="POST" action="">
                                                    <input id="place_id" name="place_id" type="hidden" value="'.$id.'">
                                                    <a class="delete" href=""><button class="btn btn-outline-danger">Удалить из избранного</button></a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>';
                                    
                                }
                            }
                            else {
                                echo "<p>Список пока пуст.</p>";
                            }
                            
                            $stmt->close();
                        }
                        catch (Exception $e){
                            // echo "<p>Ошибка</p>";
                        }

                        try {
                            if (isset($_POST["place_id"])) {
                                $place_id = $_POST["place_id"];
                                $stmt = mysqli_prepare($mysql, "DELETE FROM favourites WHERE id_place = ? AND id_user = ?");
                                $stmt->bind_param('ss', $place_id, $session_user);
                                mysqli_stmt_execute($stmt);
                                $stmt->store_result();
                                $stmt->close();
                                
                            }

                        }
                        catch (Exception $e){
                            // echo "<p>Ошибка</p>";
                        }
                    }
                }
                catch (Exception $e){
                    echo "<p>Список пока пуст.</p>";
                }
                
                
                
            ?>
                </div>
            </div>
        </div>
        </section>
    </main>
    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="container">
            <div class="row">
                <div class="col text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    Веб-сервис разработан студентом Московского Политеха<br>
                    Москва, 2024
                </div>
            </div>
        </div>        
    </footer>
</body>
</html>