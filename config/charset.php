<?php

$initial = mysqli_character_set_name($connection);

echo "<script type='text/javascript'>console.error('Initial file set is: " . $initial . "');</script>";

/* change character set to utf8 */
if (!mysqli_set_charset($connection, "utf8")) {
    echo "<script type='text/javascript'>console.error('Error loading character set utf8.');</script>"; 
    exit();
} else {
    echo "<script type='text/javascript'>console.error('Changed char set to UTF8');</script>";
}

?>
