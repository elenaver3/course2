<?php

    class Database {
        private static $instance;
        private $mysql;

        private function __construct()
        {
            try {
                define('DB_HOST', 'localhost');
                define('DB_USER', 'root'); 
                define('DB_PASSWORD', 'root'); 
                define('DB_NAME', 'course2');

                $this->mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $this->mysql->set_charset("utf8");

                if ($this->mysql->connect_error) {
                    throw new Exception('Ошибка подключения к базе данных: ' . $this->mysql->connect_error);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function getConnection()
        {
            return $this->mysql;
        }

    }

    $db = Database::getInstance();
    $mysql = $db->getConnection();
 
?>











































<?php 
    // define('DB_HOST', 'localhost');
    // define('DB_USER', 'root'); 
    // define('DB_PASSWORD', 'root'); 
    // define('DB_NAME', 'course2');
    // try {
    //     $mysql = new mysql(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    //     mysql_set_charset($mysql, "utf8");
    // }
    // catch (Exception $e) {
    //     echo "Ошибка подключения к базе данных: " . mysql_connect_error();
    //     exit();
    // }
?>
