<?php

function getUserByUsernameAndPassword($userName, $password)
{
    include("config.php");

    $query = 
            "SELECT *
            FROM    USERS U
            WHERE   U.USERNAME = ?
                    AND U.PASSWORD = ?";

    $user = $userName;
    $pass = $password;
    $row = null;
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('ss', $user, md5($pass));
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array();
        $stmt->close();
    }
    $mysqli->close();
    return $row;
}

?>