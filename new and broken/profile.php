<?php /* Template Name: Profile Template */ ?>

<?php
require 'config/config.php';
require 'includes/User_class.php';
require 'includes/Post_class.php';
require 'includes/Messenger_class.php';
require 'messageAjaxArchived.php';  // TODO - check if I can remove this

get_header();

$post = new Post($connection, $userLoggedIn); /* create new instance of Post class */
$message = new Messenger($connection, $userLoggedIn);

if(isset($_POST['post_button'])) {
        $body = strip_tags($_POST['post_textarea']);
        $user_to = $user['username'];
        $post->submitPost($body, $user_to); /* submit to function submitPost in class Post */
        }

?>

 
<!-- This is the container for the tabs -->
<div class="ccContent">

    <!-- These are the tabs themselves -->
    <input id="ccTab1" type="radio" name="tabs" onclick="stopRefresh();">
    <label for="ccTab1"><span>Profile</span></label>

    <input id="ccTab2" type="radio" name="tabs" onclick="stopRefresh();" checked>
    <label for="ccTab2"><span>Contacts</span></label>

    <input id="ccTab3" type="radio" name="tabs" onclick="callRefresh();">
    <label for="ccTab3"><span>Chat</span></label>

    <!-- This is the content of the tabs displayed beneath -->
    <section id="content1" class="tab-content">

        <div class="userDetails">     
            <?php
            if(in_array('<b><p style="color: green;">CONNECTION TO DB: soc_net ESTABLISHED</p></b>', $conn_array)) {
            echo '<b><p class="outputLog outputLog_profile">CONNECTION TO DB: soc_net ESTABLISHED</p></b>';
            }
            else {
            echo '<p class="outputLog">Error: no db connection</p>';
            }
            ?>

            <?php     
            if(isset($_SESSION['username'])) {
                $userLoggedIn = $_SESSION['username'];
                echo 'User "<b>' . $userLoggedIn . '</b>" is logged in.';
            ?>
            <br>
            <div class="profileInformation"> 
            <div class="profilePicture">
                <img src="<?php echo $user['profile_pic'];  ?>">
            </div>
            <div class="profileText">
            <u>Basic Profile:</u><br>
            <!-- See config.php for userDetails array (summed up as $user) -->
            User full name: <?php echo $user['first_name'] . " " . $user['last_name']; ?><br>
            Email Address: <?php echo $user['email'];  ?>
            </div>
            </div>

            <div class="post">
                <form class="post_form" action="/profile" method="POST">
                    <textarea name="post_textarea" id="post_textarea" placeholder="Post something."></textarea><br>
                    <input type="submit" name="post_button" value="Post">
                </form>
            </div>

            <?php
            //$post->getUserPosts($userLoggedIn);

            $get_posts_query = mysqli_query($connection, "SELECT * FROM posts WHERE added_by='$userLoggedIn'"); 
            $posts_array = mysqli_fetch_assoc($get_posts_query);
            $num_rows = mysqli_num_rows($get_posts_query);

            $i = $num_rows;
            $j = $i-5;

            for($i; $i >= $j; $i--) {
                $specific_post = mysqli_query($connection, "SELECT * FROM posts WHERE added_by='$userLoggedIn' AND user_post_id='$i'"); 
                $specific_post_array = mysqli_fetch_assoc($specific_post);

                //$num_rows = mysqli_num_rows($get_posts_query);
                if ($specific_post_array['user_post_id'] == 0) {

                }
                elseif ($specific_post_array['user_post_id'] == $i) {
                    echo "<table style ='width: 100%; box-sizing: border-box; padding: 10px;'>";
                    echo "<tr>";
                    echo "<td>User post ID: " . $specific_post_array['user_post_id'] . "</td>";
                    echo "<td>" . $specific_post_array['added_by'] . "</td>";
                    echo "<td>" . $specific_post_array['date_added'] . "</td></tr>";
                    echo "<tr><td colspan='3'>" . $specific_post_array['body'] . "</td>";
                    echo "</tr>";
                    echo "<br></table><br>";
                }
            }
            ?>

            <div id="logout">
            </div>
            <?php
            } else { echo 'User is not logged in.<br><A HREF="/register#loginTag">Log In</A> or <A HREF="/register#registerTag">Register</A>'; }
            ?>
            <div id="logout">
            </div>
        </div>

    </section>

    <section id="content2" class="tab-content">
    <div>

    <input type="submit" onclick="loadUsers(); return false;" value="Load Users" style="width: 100%; margin: 0 auto; margin-top: 10px; margin-bottom: 10px;">
    <br>
    <div id="userList">Empty...
    <br>
        

    </div>  
    </div>
    </section>

    <section id="content3" class="tab-content">

        <div class="messengerDetails">
            <div class="messengerscript">

    <?php
            $recipient = $_SESSION['recipient_username'];
            echo "<div class='messageHeader'>";
            echo "<div style='float: left;'>" . $recipient . "</div>";
            echo "<div style='float: right;'>" . $userLoggedIn . "</div>";
            echo "</div><br>"; 
    ?>           
            <div id='out' class='messagehistory'>          
                <!-- THIS IS WHERE THE MESSAGE HISTORY GOES -->
    <?php
    /* --------------------------------------------------------------------------------------- */

            $recipient = $_SESSION['recipient_username'];
            $userLoggedIn = $_SESSION['username'];

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
            mysqli_free_result($result);

            $y = $w - 100; // 100 (magic number...) is the limit of how many messages can be shown.

            mysqli_data_seek ($specific_message,$y);      
            $first_message_to_load=mysqli_fetch_row($specific_message);
            $z = $first_message_to_load['0']; /* index 0 is the id */
            mysqli_free_result($result);

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
            echo "<script>console.log('-----------------------------------------');</script>";

            // load 100 messages
            for($y; $y <= $w; $y++) {

                if (($y === $w - 100) > 0) {
                    echo "<div style='background-color: #DDD; text-align: center'><text style='color: black;'>Click to load more messages... </text><text style='color: red;'>(Feature not yet active)</text></div>";
                }

                mysqli_data_seek ($specific_message,$a);      
                $specific_message_array = mysqli_fetch_assoc($specific_message);
                $whatever_p_is = mysqli_fetch_row($specific_message);

                    if ($specific_message_array['id'] != NULL)  {
                        $timestamp = strtotime($specific_message_array['date_added']);
                        $messageTimeSent = date("H:i", $timestamp);

                        if ($specific_message_array['added_by'] == $userLoggedIn) {
                        echo "<div class='message' style='flex-direction: row-reverse;'>";
                        //echo "<img src=" . echo $user['profile_pic'] . ">";
                        echo "<div class='messageText' style='background-color: dodgerblue;'>" . $specific_message_array['body'] . "</div>";   
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

            echo "<script>console.log('-----------------------------------------');</script>";
            echo "<script>console.log('First ID posted: " . $first_message_posted . "');</script>";
            echo "<script>console.log('Last ID posted: " . $last_message_posted . "');</script>";
            echo "<script>console.log('Number of messages posted: " . $num_messages_posted . "');</script>";
            echo "<script>console.log('-----------------------------------------');</script>";

    ?>    


            </div>

            <div class="messenger">
                <form class="message_form" action="/profile" method="POST" onsubmit="submitdata(); $('.message_form')[0].reset(); return false;"> 
                    <div class="toRecipient">
                        <div class="recipientInput">
                            To: <input id="recipient" type="text" name="recipient_username" placeholder="Recipient username" value ="<?php
                            if(isset($_SESSION['recipient_username']))
                            { echo $_SESSION['recipient_username']; } else {echo ""; } ?>"
                            required>
                        </div>
                    <input type="submit" name="message_button" value="Send"></div><br>
                    <textarea type="text" class="message_textarea" id="message_body" name="message_textarea" placeholder="Send a message."></textarea><br>
                </form>
            </div>

        </div>    
    </div>
        

    </section>
               
</div>
    





</body>

<!-- sets return/ENTER keypress as a submit button for message_form -->
<script> 
$('.message_form').keydown(function(e) {
var keypress = e.which;
if (keypress == 13) {
$('.message_form').submit();
}
});
</script>



<!-- submitData() function   This ajax submits new messages sent by userLoggedIn -->
<script>
function submitdata() {
 var recipient = document.getElementById("recipient").value;
 var messagebody = document.getElementById("message_body").value;

 $.ajax({
  type: 'post',
  url: 'http://localhost/wp-content/themes/BRWNETheme/messageAjax.php',
  data: {
   recipient_username:recipient,
   message_textarea:messagebody,
  },
  success: function (response) {
    console.log('Posting message.');
    <?php
    
    ?>
  }
 });
updateMessages();
}
</script>

<!-- scrolls to the bottom of the message history div to ensure looking at the latest messages at the same time it gets the updated message list -->
<script>
var add;
    
function callRefresh() {
    var add = setInterval(updateMessages, 10000);
 
    // updates the message panel size.
    $(".messengerDetails").height($("body").height()-150);
    $(".messagehistory").height($(".messengerscript").height()-230);
    var a = document.getElementById("out");
    a.scrollTop = a.scrollHeight - a.clientHeight;
}
    
function stopRefresh() {
    clearInterval(add);
}
</script>

<script>
    function updateMessages() {        
        $(".messagehistory").load("http://localhost/wp-content/themes/BRWNETheme/includes/messenger_script.php", function( response, status, xhr ) {
            if ( status == "error" ) {
                var msg = 'Loading messenges resulted in an error: ';
                console.log(msg + xhr.status + " " + xhr.statusText );
            }
            else {
                var time;
                var time = new Date();
                var h = time.getHours();
                var m = time.getMinutes();
                var s = time.getSeconds();
                console.log('Update messages is running.',h,':',m,':',s);
                var out = document.getElementById("out");
                var isScrolledToBottom = out.scrollHeight - out.clientHeight < out.scrollTop + 300;
                console.log('Scrolled to:', (out.scrollHeight - out.clientHeight) - out.scrollTop, 'Allowed scroll limit:', 300);
                if(isScrolledToBottom) {
                    out.scrollTop = out.scrollHeight - out.clientHeight;
                }
            }
        });
    };
</script>

<script>
function loadUsers() {        
        $("#userList").load("http://localhost/wp-content/themes/BRWNETheme/get_users_script.php", function( response, status, xhr ) {
            if ( status == "error" ) {
                var msg = 'Loading users resulted in an error: ';
                console.log(msg + xhr.status + " " + xhr.statusText );
            }
        });
    };
</script>

<script>
function chatWithUser() {
       $_SESSION['recipient_username'] = $user_array['username'];
};
</script>

</html>