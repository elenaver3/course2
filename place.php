<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        include('session.php');
        include('dbconnect.php');
        $title = "Подробная информация";
        $info = array();
        $is_in_fav = false;
        $id = -1;

        try{
            if(isset($_GET['id'])) {
                $id = $_GET['id'];

                $stmt = mysqli_prepare($mysql, "SELECT places.name AS place_name, CONCAT(city, ', ', street_house) AS address, address_comment, description, website, email, place_type.name AS place_type, clean_img(image) AS img, IF(image IS NULL, clean_img(gallery), null) AS backup_img, clean_schedule(places.schedule_1) AS monday, clean_schedule(places.schedule_2) AS tuesday, clean_schedule(places.schedule_3) AS wednesday, clean_schedule(places.schedule_4) AS thursday, clean_schedule(places.schedule_5) AS friday, clean_schedule(places.schedule_6) AS saturday, clean_schedule(places.schedule_7) AS sunday, clean_img(places.external_info) AS extra_url
                FROM places JOIN place_type ON places.id_place_type=place_type.id WHERE places.id = ?");
                $stmt->bind_param('d', $id);
                mysqli_stmt_execute($stmt);

                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($name, $address, $address_comment, $description, $website, $email, $place_type, $img, $backup_img, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $extra_url);
                    $stmt->fetch();
                    
                    $info["name"] = $name;
                    $info["address"] = $address;
                    $info["address_comment"] = $address_comment;
                    $info["description"] = $description;
                    $info["website"] = $website;
                    $info["email"] = $email;
                    $info["place_type"] = $place_type;
                    $info["img"] = $img;
                    $info["backup_img"] = $backup_img;
                    $info["monday"] = $monday;
                    $info["tuesday"] = $tuesday;
                    $info["wednesday"] = $wednesday;
                    $info["thursday"] = $thursday;
                    $info["friday"] = $friday;
                    $info["saturday"] = $saturday;
                    $info["sunday"] = $sunday;
                    $info["extra_url"] = $extra_url;

                    $title = $name;   
                }
                else {
                    // echo "<p>Неверный</p>";
                }
                
                $stmt->close();

                if(isset($session_user) && $session_user != false) {
        
                    $stmt = mysqli_prepare($mysql, "SELECT id_place from favourites where id_user = ? and id_place = ?");
                    $stmt->bind_param('ss', $session_user, $id);
                    mysqli_stmt_execute($stmt);
    
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $is_in_fav = true;
                    }
                    $stmt->close();
                                                
                }
            }

        }
        catch (Exception $e){
            // echo "<p>Ошибка</p>";
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/2.0-stable/?apikey=3219e7a2-fe3c-4b3b-8fe8-b9f5a50ff778&load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <link rel="icon" href="extra/files/logo.ico" type="image/x-icon">
    <title><?php echo $title; ?></title>
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
                <?php
                    if(isset($session_user) && $session_user != false) {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="personal.php">Личный кабинет</a>
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
        <div class="container">
            <h1 class="pt-3"><?php echo $info["place_type"]; ?></h1>
        </div>
        <div class="container">
            <h2><?php echo $info["name"]; ?></h2>
            

        </div>
        <div class="container pt-3">
            <div class="row pb-3">
                <div class="col-lg-5 col-12">
                    <?php
                        if ($info["img"] != "") {
                            echo '<img class="place_photo" src="'.$info['img'].'" alt="">';
                        }
                        else {
                            echo '<img class="place_photo" src="'.$info['backup_img'].'" alt="">';
                        }
                    ?>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <p>Адрес: <?php echo $info["address"]; ?>
                        <?php 
                            if ($info["address_comment"] != "") {
                                echo ' ('.$info["address_comment"].')';
                            }
                        ?>
                    </p> 
                    <p>Почта: <?php
                        if ($info["email"] != "")
                            echo '<a href="mailto:'.$info["email"].'">'.$info["email"].'</a>';
                        else
                            echo 'не указана';
                        ?>
                    </p>
                    <p> Дополнительная информация:<br>
                        <?php 
                            if ($info["website"] != "") {
                                echo '<a target="_blank" href="'.$info["website"].'">Ссылка на сайт</a>';
                            }
                        ?>
                        <br>
                        <?php 
                            if ($info["extra_url"] != "") {
                                echo '<a target="_blank" href="'.$info["extra_url"].'">Ссылка на сайт</a>';
                            }
                            if ($info["website"] == "" && $info["extra_url"] == "")
                                echo 'не указана';
                        ?>
                    </p>
                    <?php
                        if (isset($session_user) && $session_user != false) {
                            echo '<form method="POST" action="">';
                            if($is_in_fav == true) {
                                echo '<a href=""><button class="btn btn-outline-danger" type="submit" name="delete_btn">Удалить из избранного</button></a>';
                            }
                            else {
                                echo '<a href=""><button class="btn btn-outline-success" type="submit" name="add_btn">Добавить в избранное</button></a>';
                            }
                            echo '<div id="message"></div>';
                            echo '</form>';

                            try {
                                if (isset($_POST["delete_btn"]) && $id != -1) {
                                    $stmt = mysqli_prepare($mysql, "DELETE FROM favourites WHERE id_place = ? AND id_user = ?");
                                    $stmt->bind_param('ss', $id, $session_user);
                                    mysqli_stmt_execute($stmt);
                                    $stmt->store_result();
                                    $stmt->close();
    
                                    header("Refresh: 0");
                                    // echo 'Успешно удалено';
    
                                    
                                }

                                if (isset($_POST["add_btn"]) && $id != -1) {
                                    $stmt = mysqli_prepare($mysql, "INSERT INTO favourites(id_place, id_user) VALUES (?,?)");
                                    $stmt->bind_param('ss', $id, $session_user);
                                    mysqli_stmt_execute($stmt);
                                    $stmt->store_result();
                                    $stmt->close();
    
                                    header("Refresh:0");
                                    // echo 'Успешно добавлено';
    
                                    
                                }
                            }
                            catch (Exception $e){
                                // echo "<p>Ошибка</p>";
                            }

                            
                            
                        }
                    ?>
                </div>
            </div>
            
        </div>
        <div class="container">
            <?php echo $info["description"]; ?>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>График работы</h3>
                </div>
            </div>
            <div class="row">
                <table class="table  table-hover">
                    <colgroup>
                        <col span="" style="width: 15%;">
                        <col span="" style="width: 85%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>
                                Понедельник:
                            </td>
                            <td>
                                <?php
                                if (isset($info["monday"])) {
                                    if($info["monday"] == ';') {
                                        echo 'выходной';
                                    }
                                    else {
                                        $time = explode(";", $info["monday"]);
                                        echo $time[0].' - '.$time[1];
                                    }
                                }
                                else {
                                    echo 'выходной';
                                }
                            
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Вторник:
                            </td>
                            <td>
                                <?php
                                if (isset($info["tuesday"])) {
                                    if($info["tuesday"] == ';') {
                                        echo 'выходной';
                                    }
                                    else {
                                        $time = explode(";", $info["tuesday"]);
                                        echo $time[0].' - '.$time[1];
                                    }
                                }
                                else {
                                    echo 'выходной';
                                }    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Среда:
                            </td>
                            <td>
                                <?php
                                if (isset($info["wednesday"])) {
                                    if($info["wednesday"] == ';') {
                                        echo 'выходной';
                                    }
                                    else {
                                        $time = explode(";", $info["wednesday"]);
                                        echo $time[0].' - '.$time[1];
                                    }
                                }
                                else {
                                    echo 'выходной';
                                }    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Четверг:
                            </td>
                            <td>
                                <?php
                                if (isset($info["thursday"])) {
                                    if($info["thursday"] == ';') {
                                        echo 'выходной';
                                    }
                                    else {
                                        $time = explode(";", $info["thursday"]);
                                        echo $time[0].' - '.$time[1];
                                    }
                                }
                                else {
                                    echo 'выходной';
                                }    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Пятница:
                            </td>
                            <td>
                                <?php
                                if (isset($info["friday"])) {
                                    if($info["friday"] == ';') {
                                        echo 'выходной';
                                    }
                                    else {
                                        $time = explode(";", $info["friday"]);
                                        echo $time[0].' - '.$time[1];
                                    }
                                }
                                else {
                                    echo 'выходной';
                                }    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Суббота:
                            </td>
                            <td>
                                <?php
                                    if (isset($info["saturday"])) {
                                        if($info["saturday"] == ';') {
                                            echo 'выходной';
                                        }
                                        else {
                                            $time = explode(";", $info["saturday"]);
                                            echo $time[0].' - '.$time[1];
                                        }
                                    }
                                    else {
                                        echo 'выходной';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Воскресенье:
                            </td>
                            <td>
                                <?php
                                    if(isset($info["sunday"])) {
                                        if($info["sunday"] == ';') {
                                            echo 'выходной';
                                        }
                                        else {
                                            $time = explode(";", $info["sunday"]);
                                            echo $time[0].' - '.$time[1];
                                        }
                                    }
                                    else {
                                        echo 'выходной';
                                    }
                                    
                                ?>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </main>
    
    <script type="text/javascript" src="extra/coords.js"></script>
</body>
</html>