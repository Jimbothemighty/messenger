<?php
require 'config/config.php';

if($_SESSION['username']) {
    header("Location: profile.php");
    }
else {
    header("Location: register.php");
}

?>

