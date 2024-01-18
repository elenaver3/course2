<?php

    include("dbconnect.php");

    $result = array();

    $stmt = mysqli_prepare($mysql, "SELECT places.city, COUNT(places.id) AS count FROM places GROUP BY places.city ORDER BY count DESC LIMIT 10");
    mysqli_stmt_execute($stmt);
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($city, $count);
        while ($stmt->fetch()) {
            $result[] = array(
                'city' => $city,
                'count' => $count
            );
        }        
    }
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($result);

    
?>