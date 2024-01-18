<?php

    include("dbconnect.php");

    $result = array();

    $stmt = mysqli_prepare($mysql, "SELECT place_type.name, COUNT(places.id) AS count FROM places JOIN place_type ON places.id_place_type = place_type.id GROUP BY place_type.id ORDER BY count DESC");
    mysqli_stmt_execute($stmt);
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($type_place, $count);
        while ($stmt->fetch()) {
            $result[] = array(
                'type_place' => $type_place,
                'count' => $count
            );
        }        
    }
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($result);

    
?>