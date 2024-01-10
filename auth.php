<?php
    require("dbconnect.php");

    // $result = mysqli_query($connect, "SELECT * FROM users WHERE
    //     login='".$_POST["login"]."' AND
    //     password='".$_POST["password"]."'
    // ");

    $login = $_POST["login"];
    $password = md5($_POST["password"]);

    $stmt = mysqli_prepare($mysql, "SELECT id FROM users WHERE login = ? AND password = ?");
    $stmt->bind_param('ss', $login, $password);
    mysqli_stmt_execute($stmt);
    $stmt->bind_result($id);
    $stmt->fetch();

    if (isset($id)) {
        session_start();
        $_SESSION["user"] = $id;
        header("Location: personal.php");
        $stmt->close();
    }
    else {
        echo "Введены некорректные данные.";
        exit;
    }

    $stmt->close();


    // if(!$result || mysqli_num_rows($result) == 0){
        
    // }

?>