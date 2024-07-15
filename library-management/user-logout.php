<?php
session_start();
if (isset($_GET["logout"])) {
    unset($_SESSION["email"]);
    unset($_SESSION["role"]);
    unset($_SESSION["username"]);
    unset($_SESSION["user_id"]);
    header("Location: user-login.php");
}
