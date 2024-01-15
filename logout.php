<?php
    session_start();
    unset($session_user);
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");

?>