<?php

session_start();
include_once("sessionControl.php");

function changePassword($username, $password, $name) {

    include("config.php");

    $query = 
            "UPDATE USERS
            SET     PASSWORD = ?,
                    NAME = ?
            WHERE   USERNAME = ?";

    $user = $username;
    $pass = $password;
    $personName = $name;
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('sss', md5($pass), $personName, $user);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}
?>