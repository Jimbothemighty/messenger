<?php

require '../config/config.php';

$recipient = $_SESSION['recipient_username'];
$userLoggedIn = $_SESSION['username'];
?>

<div style='float: left;'><?php echo $recipient; ?></div>
<div style='float: right;'><?php echo $userLoggedIn; ?></div>