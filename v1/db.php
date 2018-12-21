<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "gallery";

    // create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Could not connect: ' . mysqli_error($conn));
    }
    mysqli_select_db($conn,"gallery");
?>