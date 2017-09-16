<?php
    require '../includes/User_class.php';
    require '../config/config.php';

    $printed_convo_array = array();

    $conversation_list_query = mysqli_query($connection, "
    SELECT t.id, t.body, t.added_by, t.user_to, t.date_added 
    FROM messenger t 
    INNER JOIN (
        SELECT id, body, added_by, user_to, max(date_added) as MaxDate 
        FROM messenger 
        WHERE added_by='$userLoggedIn' OR user_to='$userLoggedIn' 
        GROUP BY added_by, user_to
    ) tm on (t.user_to = tm.user_to OR t.added_by = tm.added_by) and t.date_added = tm.MaxDate
    ORDER BY id DESC
    ");

        $num_rows = mysqli_num_rows($conversation_list_query);      
        $w = $num_rows;     
        
        $first_row=mysqli_fetch_row($conversation_list_query);
        $j = $first_row['0'];
        
        $x = $w-1; /* amount to move pointer by */
        mysqli_data_seek ($conversation_list_query,$x);      
        $last_row = mysqli_fetch_row($conversation_list_query);
        $i = $last_row['0']; /* index 0 is the id */

        $a = 0;

        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('Number conversations total (w): " . $w . "');</script>";
        echo "<script>console.log('Index (ID) of last stored message for this user (j) " . $j . "');</script>";
        echo "<script>console.log('Index (ID) of first stored message for this user (i): " . $i . "');</script>";
        echo "<script>console.log('-----------------------------------------');</script>";

        if ($userLoggedIn == "") {
            echo "<p>User session needs to be refreshed. This script does not recognise a logged in user.</p>";
            return;
        }
        elseif ($w == 0) {
            echo "<p>You have not started any conversations yet. Please search for a user below to start a conversation.</p>";
        }

        echo '<form id="update_recipient_form" action="profile.php" method="POST" onsubmit="return false;">';
        // load all conversations
        for($i = 0; $i <= $w; $i++) {
            mysqli_data_seek ($conversation_list_query,$a);      
            $conversation_array = mysqli_fetch_assoc($conversation_list_query);
            $whatever_p_is = mysqli_fetch_row($conversation_list_query);
            //$userRow = $user_array['username'];
            //$userSelected = new User($connection, $userRow);
            $timestamp = strtotime($conversation_array['date_added']);
            $messageTimeSent = date("H:i", $timestamp);
            $dateMessageSent = date("d/m/Y", $timestamp);
            $day = date("l", $timestamp);
            $timeNow = date("d/m/Y");
            $when = ' at ';
            
            if (($timeNow - $dateMessageSent) == 0) { $when = ' (Sent today at ' . $messageTimeSent . ')'; }
            elseif (($timeNow - $dateMessageSent) == 1) { $when = ' (Sent yesterday at ' . $messageTimeSent . ')'; }
            elseif (($timeNow - $dateMessageSent) < 7) { $when = ' (Sent on: ' . $day . ' at ' . $messageTimeSent . ')'; }
            elseif (($timeNow - $dateMessageSent) > 6) { $when = ' (On ' . $dateMessageSent . ' at ' . $messageTimeSent . ')'; }
            elseif (($timeNow - $dateMessageSent) > 31) { $when = ' (Over a month ago.)'; }
            elseif (($timeNow - $dateMessageSent) > 62) { $when = ' (Two months ago.)'; }
            elseif (($timeNow - $dateMessageSent) > 93) { $when = ' (Several months ago.)'; }
            elseif (($timeNow - $dateMessageSent) > 365) { $when = ' (Over a year ago.)'; }
            
            $messageBodyShort = $conversation_array['body'];
            $messageBodyShort = (strlen($messageBodyShort) > 49) ? substr($messageBodyShort,0,46).'...' : $messageBodyShort;
            
            
            
            if($userLoggedIn == $conversation_array['user_to']) {
                $conversationSelected = $conversation_array['added_by'];
                //$sentBy = 'Last message sent by ' . $conversation_array['added_by'] . ': ';
            }
            else {
                $conversationSelected = $conversation_array['user_to'];
                //$sentBy = 'Last message sent by me: ';
            }
            
            $id = $conversation_array["id"];
            
            echo "<script>console.log('$conversationSelected');</script>";
            if(!($id == "")) { echo "<script>console.log('ID of last message sent: $id');</script>"; }
            if (!(in_array($conversationSelected, $printed_convo_array))) {

                if ($conversation_array['id'] != NULL)  {
                /* create new instance of User class per row */
                $userC = new User($connection, $conversationSelected);
                
                if($userLoggedIn == $conversation_array['user_to']) {
                    $sentBy = 'Last message sent by ' . $userC->getFirstName() . ': ';
                }
                else {
                    $sentBy = 'Last message sent by me: ';
                }    
                
                ?>
                    <div id="results_button" onclick="chatWithUser('\ <?php echo $conversationSelected; ?>')">
                        <div id="results_image"> 
                            <div id="results_image" style="background-image: url('<?php echo $userC->getUserProfilePic(); ?>')"></div>
                        </div>
                        <div id="results_text">
                            <?php
                            echo $userC->getFirstAndLastName();
                            echo '<p>' . $sentBy . $messageBodyShort  . $when . '</p>';
                            ?>
                        </div>
                    </div>
                <?php
                array_push($printed_convo_array, $conversationSelected);
                }
            }
                //else {
                    //echo "<br>Row is missing data.<br>";
                //}
                //mysqli_free_result($result);
            $a++;
        }
        echo '</form>';
?>
