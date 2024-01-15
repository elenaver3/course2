<?php
    session_start();
    $session_user = (isset($_SESSION["user_id"])) ? $_SESSION["user_id"] : false;
?>