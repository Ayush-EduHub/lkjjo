<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "eduhub_database";

    
    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

?>