<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "library_database";
$db_connection_object = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$db_connection_object) {
    echo "DB Connection failed. Please check the parameters passed in db connection object and fix the connection";
}

session_start();



?>
