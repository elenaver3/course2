<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        include('session.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="extra/style.css">
    <link rel="icon" href="extra/files/logo.ico" type="image/x-icon">    
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-bundle.min.js"></script>
    
    <title>Проект</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="extra/files/logo.svg" alt="" srcset=""></a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Поиск</a>
                </li>
                <?php
                    if(isset($_SESSION["user_id"]) && $session_user != false) {
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
    <header class="header">
        <div class="overlay"></div>
        <div class="container">
            <div class="description ">
                <h1 class="pt-5 overlay_color">Сервис для подбора мест<br>культурного досуга и отдыха</h1>
                <p class="overlay_color">Ваш помощник в поиске ближайших объектов<br>при путешествии по России </p>
            </div>
        </div>
    </header>
    <main>

        <div class="container pt-3">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <h3>О проекте</h3>
                </div>
            </div>
            <div class="row back_color ps-3 pe-3 pt-3">
                <div class="col">
                    <p>Данный сервис позволит найти ближайшие места для культурного отдыха в зависимости от вашего расположения.</p>
                </div>
            </div>
        </div>

        <div class="container pt-3">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <h3>Статистика</h3>
                </div>
            </div>
            <div class="row ps-3 pe-3 pt-3">
                <div class="col">
                    <p>В базе данных есть информация о более чем 25 тысяч мест культурного досуга.</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div id="chartContainer" style="width: 800px; height: 500px;"></div>
            </div>
            <div class="row d-flex justify-content-center">
                <div id="chartContainer2" style="width: 800px; height: 500px;"></div>
            </div>
            
        </div>

        <div class="container pt-3 block_t mb-3">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <h3>Источники данных</h3>
                </div>
            </div>
            <div class="row back_color ps-3 pe-3 pt-3">
                <div class="col">
                    <p>При разработке веб-сервиса использовались наборы данных с <a href="https://opendata.mkrf.ru/opendata" class="link-success text_d" target="_blank">Портала открытых данных Министерства культуры Российской Федерации</a></p>
                </div>
            </div>
            <div class="row back_color ps-3 pe-3 pb-3">
                <div class="col-2">
                    <p>Библиотеки:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-libraries" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
                <div class="col-2">
                    <p>Парки:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-parks" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
                <div class="col-2">
                    <p>Музеи:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-museums" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
                <div class="col-2">
                    <p>Театры:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-theaters" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
                <div class="col-2">
                    <p>Кинотеатры:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-cinema" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
                <div class="col-2">
                    <p>Цирки:<br><a href="https://opendata.mkrf.ru/opendata/7705851331-circuses" class="link-success text_d" target="_blank">Ссылка</a></p>
                </div>
            </div>
            
            
        </div>
    
    </main>
    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="container">
            <div class="row">
                <div class="col-6 text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    Использованные источники:<br>
                    <span class="copyright"><a target="_blank" href="https://ru.freepik.com/free-photo/row-of-old-textbooks-fills-antique-bookshelf-generated-by-ai_42177969.htm">Изображение от vecstock</a> на Freepik</span>
                </div>
                <div class="col-6 text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    Веб-сервис разработан студентом Московского Политеха<br>
                    Москва, 2024
                </div>
            </div>
        </div>        
    </footer>
    
    <script type="text/javascript" src="extra/main.js"></script>
</body>
</html>

