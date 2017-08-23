<?php


ob_start();
session_start();

$timezone = date_default_timezone_set("Europe/London");

$connection = mysqli_connect("better-planet.org", "josh1234", "jabberwocky1234", "soc_net"); // connection variable
$conn_array = array();

if(mysqli_connect_errno())
{
    //echo "Failed to connect: " . mysqli_connect_errno();
} else { array_push($conn_array, '<b><p style="color: green;">CONNECTION TO DB: soc_net ESTABLISHED</p></b>'); }

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $userDetails = mysqli_query($connection, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_assoc($userDetails);
    
    /* TODO - it is recommended to not use mysqli_fetch_array. Instead to use mysqli_fetch_assoc or mysqli_fetch_row as this have better performance and are tigher in their usage as the fetch_array one is sort of a combination of the other two functions - so more cumbersome, but more flexible in how you can access the data it returns (i.e. by either a string or numeric index).
    
    according to websites I have looked at - fetch_assoc has the best speed
    
    fetch_assoc uses a string index (name of column in SQL table)*/
}

/* --------------------------------------------------------------------------------------- */

        $recipient = $_SESSION['recipient_username'];
        $userLoggedIn = $_SESSION['username'];
        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('Messenger script is running');</script>";
        echo "<script>console.log('Recipient is: " . $recipient . "');</script>";
        echo "<script>console.log('UserLoggedIn is: " . $userLoggedIn . "');</script>";

        $get_messages_query = mysqli_query($connection, "SELECT * FROM messenger WHERE (added_by='$userLoggedIn' AND user_to='$recipient') OR (added_by='$recipient' AND user_to='$userLoggedIn')"); 
        //$messages_array = mysqli_fetch_assoc($get_messages_query);
        
        $num_rows = mysqli_num_rows($get_messages_query);      
        $w = $num_rows;
        echo 'Number of messages in conversation: ' . $w . ' | ';      
        
        $first_row=mysqli_fetch_row($get_messages_query);
        $j = $first_row['0'];
        echo 'ID of first stored message: ' . $j . " | ";
        
        $x = $w-1; /* amount to move pointer by */
        mysqli_data_seek ($get_messages_query,$x);      
        $last_row=mysqli_fetch_row($get_messages_query);
        $i = $last_row['0']; /* row 0 is the id */
        echo 'ID of last stored message: ' . $i . "";
        mysqli_free_result($result);
        
        if($x > 100) {
            $y = $x - 100; // 100 (magic number...) is the limit of how many messages can be shown.
        }

        echo "<div class='messageHeader' style='box-sizing: border-box; padding: 20px; border-bottom: 1px solid white;'>";
        echo "<div style='float: left;'>" . $recipient . "</div>";
        echo "<div style='float: right;'>" . $userLoggedIn . "</div>";
        echo "</div><br>";


        echo "<div class='messagehistory' style='overflow-y: scroll; box-sizing: border-box; padding-left: 20px; padding-right: 20px;'>";

        for($i; $i >= $j; $i--) {
            //$recipient = $_SESSION['recipient_username'];
            
            $specific_message = mysqli_query($connection, "SELECT * FROM messenger WHERE (added_by='$userLoggedIn' AND user_to='$recipient') OR (added_by='$recipient' AND user_to='$userLoggedIn')");
            
            mysqli_data_seek ($specific_message,$x);      
            $specific_message_array = mysqli_fetch_assoc($specific_message);

            if ($x < $y) {
                echo "<br><div style='text-align: center'>Load more...</div>";
                return 0;
            }
            elseif ($specific_message_array['id'] == $i) {
                //echo $i . "<br>";
                $timestamp = strtotime($specific_message_array['date_added']);
                $messageTimeSent = date("H:i:s", $timestamp);
                
                if ($specific_message_array['added_by'] == $userLoggedIn) {
                echo "<div class='message' style='flex-direction: row-reverse;'>";
                //echo "<img src=" . echo $user['profile_pic'] . ">";
                echo "<div class='messageText' style='background-color: dodgerblue;'>" . $specific_message_array['body'] . "</div>";   
                }
                else {
                echo "<div class='message'>";
                echo "<div class='messageText'>" . $specific_message_array['body'] . "</div>";
                }
                //echo "<div class='messageSender'>" . $specific_message_array['added_by'] . ": </div>";
                echo "<div class='messageDate'>" . $messageTimeSent . " " . /*" (id:" . $specific_message_array['id'] . ")*/"</div>";
                echo "</div>";
                $x--;
                if ($x < 0) {
                echo "<br><div style='text-align: center'>Last message in conversation.</div>";
                return 0;
            }
            }
            elseif ($specific_message_array['id'] != $i) {
                /* echo "ID = " . $i . " | ";
                echo "Convo row = " . $x . " | ";
                echo "Row is not for this conversation<br>"; */
            }
        }
        echo "</div>";
    ?>