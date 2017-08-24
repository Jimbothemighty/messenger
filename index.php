<?php
ob_start();
session_start();

if($_SESSION['username']) {
    header("Location: /messenger/profile.php");
    }
else {
    header("Location: /messenger/register.php");
}

?>

