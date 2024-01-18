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
    <script src="https://api-maps.yandex.ru/2.0-stable/?apikey=5d703633-d47a-43ac-9b1d-cf23d7fb6c2a&load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <link rel="icon" href="extra/files/logo.ico" type="image/x-icon">
    <title>Поиск мест</title>
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
                    <a class="nav-link active" href="search.php">Поиск</a>
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
        <div class="container pb">
            <div class="row mt-3">
                <div class="col d-flex justify-content-center">
                    <h1>Поиск мест культурного досуга</h1>
                </div>
            </div>
            
        </div>
        <div class="container">
            <form action="search.php" method="POST" id="search">
                <div class="row pb-3 pt-2">
                    <div class="col-1"></div>
                    <div class="col-7">
                    <p>Ваше местоположение:</p>
                        <div class="map" id="map"></div>
                    </div>
                    <div class="col">
                        
                        <div class="slider">
                            <p>Радиус подбора (в км):<br></p>
                            <input type="range" name="range" min="0.5" max="100" value="5" step="0.5" oninput="rangeValue.innerText = this.value">
                            <p id="rangeValue">5</p>
                        </div> 
                        <div class="back_color p-2">
                            
                            <p>Для подбора мест досуга установите ваше местоположение на карте и выберите радиус расстояния, подходящего для поиска.<br>Если у вас есть предпочтения о конкретных местах, то можете выбрать их ниже. При отсутствии выбора, будут подобраны места всех типов.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-5"></div>
                    <div class="col">
                    <h3>Предпочтения:</h3>
                    
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row pb-3">
                    <div class="col-3"></div>
                    <div class="col">
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
                            <div class="col-6 col-sm-3">
                                <input type="checkbox" id="cinema" name="cinema" value="2" />
                                <label for="cinema">Кинотеатры</label>
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
                            <div class="col-6 col-sm-3">
                                <input type="checkbox" id="park" name="park" value="5" />
                                <label for="park">Парки</label>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-5"></div>
                    <div class="col">
                        <p><input type="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Подобрать места"></p>
                        <input id="coordinates" name="coordinates" type="hidden">
                    </div>
                </div>    
                    
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

                        $stmt = mysqli_prepare($mysql, "SELECT id, name, city, street_house FROM places WHERE check_distance(ROUND(?,6),ROUND(?,6),places.map_point_lat,places.map_point_long) <= ? AND places.id_place_type IN (?)");
                        $stmt->bind_param('ddds', $coords[0], $coords[1], $range, $prefer);
                        mysqli_stmt_execute($stmt);

                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            // echo '<div class="container">Поиск: <input type="text" name="new_search"></div>';
                            $stmt->bind_result($id, $name, $city, $street_house);
                            while ($stmt->fetch()) {
                                echo '<div class="container p-3 mt-3 mb-3 border border-4 border-black ">
                                        <div class="row">
                                            <div class="col-8">
                                                <h4>'.$name.'</h4>
                                                <p>'.$city.' '.$street_house.'</p>
                                            </div>';
                                        
                                echo '<div class="col-4 d-flex justify-content-center">
                                <a target="_blank" href="place.php?id='.$id.'"><button class="btn btn-outline-primary">Подробнее</button></a>
                                </div></div></div>';
        
                                
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
                
                

                function add_fav($place_id, $user_id){
                    $stmt = mysqli_prepare($mysql, "INSERT INTO favourites (id_user, id_place) VALUES (?, ?)");
                    $stmt->bind_param('ss', $user_id, $place_id);
                    mysqli_stmt_execute($stmt);
                    $stmt->store_result();

                    $stmt->close();
                    
                }
                
            ?>
        </div>
    </main>
    
    <script type="text/javascript" src="extra/coords.js"></script>
</body>
</html>