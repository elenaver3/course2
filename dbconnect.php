<?php 
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root'); 
    define('DB_PASSWORD', 'root'); 
    define('DB_NAME', 'course2');
    try {
        $mysql = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        mysqli_set_charset($mysql, "utf8");
    }
    catch (Exception $e) {
        echo "Ошибка подключения к базе данных: " . mysqli_connect_error();
        exit();
    }
?>
