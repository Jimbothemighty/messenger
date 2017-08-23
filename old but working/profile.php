<?php

require 'config/config.php';
require 'includes/reg_handler.php';
require 'includes/login_handler.php';
include 'header.php';

?>

<?php
// TODO - these two lines are causing trouble. don't think i've imported the post and messenger classes properly yet
//$post = new Post($connection, $userLoggedIn); /* create new instance of Post class */
//$message = new Messenger($connection, $userLoggedIn);

if(isset($_POST['post_button'])) {
        $body = strip_tags($_POST['post_textarea']);
        $user_to = $user['username'];
        $post->submitPost($body, $user_to); /* submit to function submitPost in class Post */
        }

if(isset($_POST['message_button'])) {
        $body = strip_tags($_POST['message_textarea']);
        $user_to = strip_tags($_POST['recipient_username']);
        $_SESSION['recipient_username'] = $user_to;
        $message->submitMessage($body, $user_to);
        echo "<script>console.log('Calling submitMessage function');</script>";
        }
?>


<div class="profile_wrapper">
    <div class="userDetails profile">     
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
            <form class="post_form" action="profile.php" method="POST">
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
        } else { echo 'User is not logged in.<br><A HREF="messenger/register#loginTag">Log In</A> or <A HREF="/register#registerTag">Register</A>'; }
        ?>
        <div id="logout">
        </div>
    </div>
    <div class="userDetails feed">
        <div class="messenger">
            <form class="message_form" action="profile.php" method="POST"> 
                To: <input type="text" name="recipient_username" placeholder="Recipient username" value ="<?php
                if(isset($_SESSION['recipient_username']))
                { echo $_SESSION['recipient_username']; } else {echo ""; } ?>"
                required><input type="submit" name="message_button" value="Send / Refresh"><br>
                <textarea name="message_textarea" id="message_textarea" placeholder="Send a message."></textarea><br>
            </form>
        </div>

        <div class="messengerscript">
            Loading conversation...
            <!-- THIS IS WHERE THE MESSAGE HISTORY GOES -->
        </div>
    </div>    
</div>

    
</body>
</html>