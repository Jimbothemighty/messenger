<?php
    require '../config/config.php';
?>

<?php
/* --------------------------------------------------------------------------------------- */

        $recipient = $_SESSION['recipient_username'];
        $userLoggedIn = $_SESSION['username'];

        if ($userLoggedIn == "") {
            echo "Please log in to begin/continue a conversation.";
            return;          
        }

        if ($recipient == "") {
            echo "Please select a user to chat with.";
            return;
        }

        $specific_message = mysqli_query($connection, "SELECT * FROM messenger WHERE (added_by='$userLoggedIn' AND user_to='$recipient') OR (added_by='$recipient' AND user_to='$userLoggedIn') ORDER BY id ASC"); 
        //$messages_array = mysqli_fetch_assoc($specific_message);
        
        $num_rows = mysqli_num_rows($specific_message);      
        $w = $num_rows;     
        
        $first_row=mysqli_fetch_row($specific_message);
        $j = $first_row['0'];
        
        $x = $w-1; /* amount to move pointer by */
        mysqli_data_seek ($specific_message,$x);      
        $last_row=mysqli_fetch_row($specific_message);
        $i = $last_row['0']; /* index 0 is the id */
        //mysqli_free_result($result);

        $y = $w - 100; // 100 (magic number...) is the limit of how many messages can be shown.

        mysqli_data_seek ($specific_message,$y);      
        $first_message_to_load=mysqli_fetch_row($specific_message);
        $z = $first_message_to_load['0']; /* index 0 is the id */
        //mysqli_free_result($result);

        $a = $y;
        $first_m = $y;
        $last_m = $x;
        $first_message_posted = 0;
        $last_message_posted = 0;
        $num_messages_posted = 0;

        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('Number of messages in convo - 100 (y): " . $y . "');</script>";  // y: where to start counting from
        echo "<script>console.log('Number of messages in conversation (w): " . $w . "');</script>"; // w: where to end counting to
        echo "<script>console.log('ID of first stored message: (j) " . $j . "');</script>";         // j: position of 1st convo message in table (by id)
        echo "<script>console.log('ID of first message to LOAD (z): " . $z . "');</script>";        // z: id of first message to display
        echo "<script>console.log('ID of last stored message (i): " . $i . "');</script>";          // i: id of last message to display (and last in table by id)
        echo "<script>console.log('Session recipient stored: " . $_SESSION['recipient_username'] . "');</script>"; 
        echo "<script>console.log('-----------------------------------------');</script>";

        /*
        // These few lines of code is not working :S breaks messenger for some reason
        if (($y > 100) {
            echo "<div style='background-color: #DDD; text-align: center'><text style='color: black;'>Click to load more messages... </text><text style='color: red;'>(Feature not yet active)</text></div>";
        }
        */

        // load 100 messages
        for($y; $y <= $w; $y++) {
            
            mysqli_data_seek ($specific_message,$a);      
            $specific_message_array = mysqli_fetch_assoc($specific_message);
            $whatever_p_is = mysqli_fetch_row($specific_message);
            
                if ($specific_message_array['id'] != NULL)  {
                    $timestamp = strtotime($specific_message_array['date_added']);
                    $messageTimeSent = date("H:i", $timestamp);
                    


                    if ($specific_message_array['added_by'] == $userLoggedIn) {
                    echo "<div class='message' style='flex-direction: row-reverse;'>";
                    //echo "<img src=" . echo $user['profile_pic'] . ">";
                    echo "<div class='messageText' style='background-color: darkviolet;'>" . $specific_message_array['body'] . "</div>";   
                    }
                    else {
                    echo "<div class='message'>";
                    echo "<div class='messageText'>" . $specific_message_array['body'] . "</div>";
                    }
                    echo "<div class='messageDate'>" . $messageTimeSent . "</div>";
                    echo "</div>";
                    
                    if($a === $first_m) { $first_message_posted = $specific_message_array['id']; }
                    if($a === $last_m) { $last_message_posted = $specific_message_array['id']; }
                    $num_messages_posted++;
                    //echo "<script>console.log('" . $num_messages_posted . ": row number in array to start seeking with (a): " . $a . " | Number of messages in conversation (array id): " . $specific_message_array['id'] . "');</script>";
                }
                else {
                    //echo "Row is not for this conversation or not in range selected.<br>";
                }
                //mysqli_free_result($result);
                $a++;
        }
        /* -- for debugging
        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('First ID posted: " . $first_message_posted . "');</script>";
        echo "<script>console.log('Last ID posted: " . $last_message_posted . "');</script>";
        echo "<script>console.log('Number of messages posted: " . $num_messages_posted . "');</script>";
        echo "<script>console.log('-----------------------------------------');</script>";
        */
?>