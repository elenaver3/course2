<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        include('session.php');
        include('dbconnect.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/2.0-stable/?apikey=3219e7a2-fe3c-4b3b-8fe8-b9f5a50ff778&load=package.standard&lang=ru-RU" type="text/javascript"></script>
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
                    <a class="nav-link active" href="search.php">Поиск</a>
                </li>
                <?php
                    if(isset($session_user)) {
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
            <form action="search.php" method="POST">
                <!-- <p><input type="radio" name="type_place" value="2">Кинотеатр</p>
                <p><input type="radio" name="type_place" value="Парк">Парк</p> -->

                <!-- <p><input type="radio" name="type_choose" value="map_choose">Выбор по карте</p>
                <p><input type="radio" name="type_choose" value="ыгиоу">Выбор по субъекту</p> -->
                <div class="slider">
                    <input type="range" name="range" min="0" max="100" value="5" oninput="rangeValue.innerText = this.value">
                    <p id="rangeValue">5</p>
                </div> 
                <div id="map" style="width: 600px; height: 400px"></div>

                <h3>Предпочтения:</h3>
                <div class="container">
                    <div class="row align-items-start">
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="biblio" name="biblio" value="1" />
                            <label for="biblio">Библиотеки</label>
                        </div>
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="museum" name="museum" value="4" />
                            <label for="museum">Музеи</label>
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="cinema" name="cinema" value="2" />
                            <label for="cinema">Кинотеатры</label>
                        </div>
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="park" name="park" value="5" />
                            <label for="park">Парки</label>
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="circus" name="circus" value="3" />
                            <label for="circus">Цирки</label>
                        </div>
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" id="theater" name="theater" value="6" />
                            <label for="theater">Театры</label>
                        </div>
                    </div>
                </div>
                

                <p><input type="submit" name="submit" class="button" value="Подобрать места"></p>
                <input id="coordinates" name="coordinates" type="hidden">
            </form>
        </div>
        <div class="container">
            
            <?php
                try{
                    if(isset($_POST['coordinates']) && isset($_POST['range'])) {
                        $coords = $_POST['coordinates'];
                        $coords = explode(',', $coords);
                        $range = $_POST['range'];
                        $prefer = "";
                        if (isset($_POST['biblio'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 1";
                            else
                                $prefer = $prefer . "1";
                        }
                        if (isset($_POST['cinema'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 2";
                            else
                                $prefer = $prefer . "2";
                        }
                        if (isset($_POST['circus'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 3";
                            else
                                $prefer = $prefer . "3";
                        }
                        if (isset($_POST['museum'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 4";
                            else
                                $prefer = $prefer . "4";
                        }
                        if (isset($_POST['park'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 5";
                            else
                                $prefer = $prefer . "5";
                        }
                        if (isset($_POST['theater'])) {
                            if ($prefer != "")
                                $prefer = $prefer . ", 6";
                            else
                                $prefer = $prefer . "6";
                        }
                        
                        if ($prefer == "") {
                            $prefer = "1, 2, 3, 4, 5, 6";
                        }

                        $stmt = mysqli_prepare($mysql, "SELECT places.name FROM places WHERE check_distance(ROUND(?,6),ROUND(?,6),places.map_point_lat,places.map_point_long) <= ? AND places.id_place_type IN (?)");
                        $stmt->bind_param('ddds', $coords[0], $coords[1], $range, $prefer);
                        mysqli_stmt_execute($stmt);

                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($name);
                            while ($stmt->fetch()) {
                                
                                echo $name;
                            }
                        }
                        else {
                            echo "<p>Нет подходящих мест. Пожалуйста, выберите другие параметры.</p>";
                        }
                        
                        $stmt->close();
                    }
                }
                catch (Exception $e){
                    echo "<p>Нет подходящих мест. Пожалуйста, выберите другие параметры.</p>";
                }
                
                
                
            ?>
        </div>
    </main>
    <script type="text/javascript" src="extra/coords.js"></script>
</body>
</html>