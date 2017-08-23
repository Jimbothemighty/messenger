<?php /* Template Name: Log out Template */ ?>

<?php
require 'messenger/config/config.php';

session_destroy();
header("Location: messenger/register.php");
exit();
?>