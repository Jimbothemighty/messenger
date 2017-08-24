<?php
ob_start();
session_start();

$recipient = $_SESSION['recipient_username'];
$userLoggedIn = $_SESSION['username'];
?>

<div style='float: left;'><?php echo $recipient; ?></div>
<div style='float: right;'><?php echo $userLoggedIn; ?></div>

<script>
console.log('recip: <?php echo $recipient; ?>');
console.log('u_logged: <?php echo $userLoggedIn; ?>');
</script>