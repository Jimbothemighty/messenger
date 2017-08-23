<?php


if($_SESSION['username']) {
    header("Location: /messenger/profile.php");
    exit();
    }
else {
    header("Location: /messenger/register.php");
}


