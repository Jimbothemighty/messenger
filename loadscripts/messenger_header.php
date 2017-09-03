<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache");

header("Access-Control-Allow-Origin: *");

ob_start();
session_start();

$recipient = $_SESSION['recipient_username'];
$userLoggedIn = $_SESSION['username'];
?>

<div style='float: left;'><?php echo $recipient; ?></div>
<div style='float: right;'><?php echo $userLoggedIn; ?></div>