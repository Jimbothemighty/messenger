<?php
require '../config/config.php';

if(isset($_POST['recipient_username'])) {
        
        $body = strip_tags($_POST['message_textarea']);
        $body = mysqli_real_escape_string($connection, $body);
    
        $user_to = strip_tags($_POST['recipient_username']);
        $user_to = str_replace(' ', '', $user_to);
        $_SESSION['recipient_username'] = $user_to;
        $logfile = fopen("newlogfile.txt", "a");
        $u = $_SESSION['username'];
        $ut = $_POST['recipient_username'];
        $b = $_POST['message_textarea'];
        //$date = date();
    
        fwrite($logfile, "Log" . ":" . PHP_EOL);
        fwrite($logfile, $u."   ");
        fwrite($logfile, $ut."   ");
        fwrite($logfile, $b. PHP_EOL);
        fwrite($logfile, "-----------------------------------------------------". PHP_EOL);
    
        fclose($logfile);
        if($body != '') {
        $date_added = date("Y-m-d H:i:s");
        $added_by = $_SESSION['username'];
        $user_messages_id = 0;

        $query_messages = mysqli_query($connection, "INSERT INTO messenger VALUES (NULL, '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$user_messages_id' )");   
        }
}

?>