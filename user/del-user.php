<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/function.php";
require "../module/mode-user.php";


$id = $_GET['id'];
$foto = $_GET['foto'];


if (deleteUser($id, $foto)) {
    header("location: data-user.php?msg=deleted");
    exit();
} else {
    header("location: data-user.php?msg=aborted");
    exit();
}
