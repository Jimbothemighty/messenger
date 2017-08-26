<?php
    //require 'includes/User_class.php';

    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Europe/London");

    $connection = mysqli_connect("localhost", "root", "root", "soc_net"); // connection variable
    $conn_array = array();

    $userLoggedIn = $_SESSION['username'];

    $printed_convo_array = array();
?>

<?php

$conversation_list_query = mysqli_query($connection, "
SELECT t.id, t.body, t.added_by, t.user_to, t.date_added 
FROM messenger t 
INNER JOIN (
    SELECT id, body, added_by, user_to, max(date_added) as MaxDate 
    FROM messenger 
    WHERE added_by='$userLoggedIn' OR user_to='$userLoggedIn' 
    GROUP BY user_to
) tm on t.user_to = tm.user_to and t.date_added = tm.MaxDate
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
        mysqli_free_result($result);

        $a = 0;

        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('Number conversations total (w): " . $w . "');</script>";
        echo "<script>console.log('Index (ID) of last stored message for this user (j) " . $j . "');</script>";
        echo "<script>console.log('Index (ID) of first stored message for this user (i): " . $i . "');</script>";
        echo "<script>console.log('-----------------------------------------');</script>";

        echo '<form id="update_recipient_form" action="profile.php" method="POST" onsubmit="return false;">';
        // load all users
        for($i; $i <= $j; $i++) {
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
            $messageBodyShort = (strlen($messageBodyShort) > 50) ? substr($messageBodyShort,0,47).'...' : $messageBodyShort;
            
            if($userLoggedIn == $conversation_array['user_to']) {
                $conversationSelected = $conversation_array['added_by'];
                $sentBy = 'Last message sent by ' . $conversation_array['added_by'] . ': ';
            }
            else {
                $conversationSelected = $conversation_array['user_to'];
                $sentBy = 'Last message sent by me: ';
            }
            
            if (!(in_array($conversationSelected, $printed_convo_array))) {

                if ($conversation_array['id'] != NULL)  {
                ?>
                    <script>
                    // TODO - move script to messenger.js
                    // TODO - this is a bit hacky. There's something wrong with the php variable I'm submitting as a string. For some reason it has a space " " at the start. But if I delete it, I get an error. Currently I'm deleting the space in php in messageAjax.php, which is where this is submitting to. 
                    var inputElement = document.createElement('input');
                    inputElement.type = "button";
                    inputElement.value = 
                    ' <?php
                    echo $conversationSelected;
                    echo ' | ' . $sentBy . $messageBodyShort  . $when;    
                    ?>';
                    inputElement.addEventListener('click', function(){
                        chatWithUser('\ <?php echo $conversationSelected; ?>');
                    });

                    document.getElementById("update_recipient_form").appendChild(inputElement);
                    </script>

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

<script>
    /*
// TODO - move this to header when fully ready
function chatWithUser(x) {
var recipient = x;

$.ajax({
    type: 'post',
    url: 'http://localhost/messenger/loadscripts/messageAjax.php',
    data: {
        recipient_username:recipient,
    },
    success: function (response) {
    console.log('chatWithUser(): Updating Recipient...');
    //console.log('New recipient is: ', recipient);
    }
});

document.getElementById("ccTab3").click();
callRefresh();
}
*/
</script>
