<?php
session_start();
if (!empty($_POST['access'])) {
    switch ($_POST['access']) {
        case "T":
            $_SESSION['access'] = "Преподаватель";
            $_SESSION['username'] = "Феногенов Антон";
            break;
        case "R":
            $_SESSION['access'] = "Руководитель ОПОП";
            $_SESSION['username'] = "Русанов Михаил";
            break;
        case "L":
            $_SESSION['access'] = "Библиотека";
            $_SESSION['username'] = "Работник библиотеки";
            break;
        case "O":
            $_SESSION['access'] = "";
            session_destroy();
            break;
        default:
            exit();
    }
} else exit();
?>