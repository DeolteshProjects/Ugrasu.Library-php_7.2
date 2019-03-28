<?php
session_start();
if (!empty($_POST['access'])) {
    switch ($_POST['access']) {
        case "T":
            $_SESSION['access'] = "Преподаватель";
            break;
        case "R":
            $_SESSION['access'] = "Руководитель ОПОП";
            break;
        case "L":
            $_SESSION['access'] = "Библиотека";
            break;
        default:
            exit();
    }
} else exit();
?>