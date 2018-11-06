<?php
session_start();
if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 1800)) {
    session_unset();
    session_destroy();
}
if (isset($_GET["login"]) && $_GET["login"] == true && !isset($_SESSION["is_login"])) {
    $errors = (!empty($_SESSION["errors"])) ? $_SESSION["errors"] : "";
    $error = (!empty($errors)) ? $errors : "";
    include_once "template/login.php";
    unset($_SESSION["errors"]);
} else {
    include_once "template/home.php";
}