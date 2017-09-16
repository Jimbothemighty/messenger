<?php
require 'config/config.php';
require 'config/charset.php';

require 'includes/User_class.php';
require 'includes/Post_class.php';

include 'header.php';

    //echo "<script>console.log('Profile page; Session User is: " . $userLoggedIn . "');</script>";
    //echo "<script>console.log('Profile page; Session ID is: "  . session_id() . "');</script>";
?>

<?php
// TODO - these two lines are causing trouble. don't think i've imported the post and messenger classes properly yet
$post = new Post($connection, $userLoggedIn); /* create new instance of Post class */

if(isset($_POST['post_button'])) {
        $body = strip_tags($_POST['post_textarea']);
        $user_to = $user['username'];
        $post->submitPost($body, $user_to); /* submit to function submitPost in class Post */
        }

if(file_exists($user['profile_pic']))
    $fileName = $user['profile_pic'];
else
    $fileName = "assets/images/profilepic/default.png";

?>
<div id="loadingOverlay" style="display: none; flex-direction: column; align-items: center; justify-content: center;">
    <div style="order: 1;">
        <div id="loadAnimation"></div>
        <div style="text-align: center; margin: 0 auto;">Loading... <?php echo $current ?></div>
        <button style="text-align: center; margin: 0 auto;" onclick="document.getElementById('loadingOverlay').style.display='none';">Cancel</button>
    </div>
</div>

<div class="ccContent">

    <!-- These are the tabs themselves -->
    <input id="ccTab1" type="radio" name="tabs" onclick="stopRefresh();" checked>
    <label for="ccTab1"><span>Profile</span></label>

    <input id="ccTab2" type="radio" name="tabs" onclick="stopRefresh(); loadConversations();">
    <label for="ccTab2"><span>Conversations</span></label>

    <input id="ccTab3" type="radio" name="tabs" onclick="callRefresh();">
    <label for="ccTab3"><span>Chat</span></label>

    <!-- This is the content of the tabs displayed beneath -->
    <section id="content1" class="tab-content">

        <div class="userDetails">     
            <?php     
            if(isset($_SESSION['username'])) {
                $userLoggedIn = $_SESSION['username'];
                echo 'User "<b>' . $userLoggedIn . '</b>" is logged in.';
            ?>
            <br>
            <div class="profileInformation"> 
                <div class="profilePicture">
                    <div style="
                                width: 170px;
                                height: 170px;
                                background-size: cover;
                                background-repeat: no-repeat;
                                background-position: center;
                                background-image: url('<?php echo $fileName; ?>')">
                    </div>
                <!-- <img src="<?php echo $fileName; ?>" "style=width: 170px; height: 170px;"> -->
                </div>
                <div class="profileText">
                <u>Basic Profile:</u><br>
                <!-- See config.php for userDetails array (summed up as $user) -->
                User full name: <?php echo $user['first_name'] . " " . $user['last_name']; ?><br>
                Email Address: <?php echo $user['email'];  ?><br>
                    <button type="button" style="width: 200px; height: 50px; color: black;" onclick="document.getElementById('update_pic').style.display='block';" value="Update Profile picture">Update Profile picture</button>
                    <div id="update_pic" style="display:none;">
                        <form action="upload.php" id="uploadForm" method="post" enctype="multipart/form-data" onsubmit="document.getElementById('loadingOverlay').style.display='flex'; document.getElementById('loadAnimation').style.display='block';">
                            Select image to upload:<br>
                            <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
                            <div style="overflow: hidden; max-width: 300px;">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </div>
                            <input type="submit" value="Upload Image" name="upload_profilepic">
                        </form>
                    </div>
                </div>
            </div>

            <div class="post">
                <form class="post_form" action="/messenger/profile.php" method="POST">
                    <textarea name="post_textarea" id="post_textarea" placeholder="Post a status update."></textarea><br>
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
            <?php
            } else { echo 'User is not logged in.<br><A HREF="/messenger/register.php/#loginTag">Log In</A> or <A HREF="/messenger/register.php/#registerTag">Register</A>'; }
            ?>
        </div>

    </section>

    <section id="content2" class="tab-content">
        <div class="conversationsWrapper">
            <br>
            <div class="generalHeader">Search for Users</div>
            <form class="search_form" action="/messenger/searchUsersAjax.php" method="POST" onsubmit="submitSearch(); return false;">
                <input id="searchTerm" type="text" name="searchTerm" autocomplete="off" placeholder="Search for Users" value ="">
                <input type="submit" value="Load Users" onclick="">
            </form>    
            <br>
            
            <div id="searchLoadAnimation" class="loader" style="display: none;"></div>
            <div id="userList"></div>
                <!-- get search results -->       

            <div class="generalHeader">Conversation List</div>
            <div id="convoList">Loading...</div>
            <br>

        </div>
    </section>

    <section id="content3" class="tab-content">

        <div class="messengerDetails">
            <div class="messengerscript">
                <div class='messageHeader'>
                <div style='float: left;'><?php echo $recipient; ?></div>
                <div style='float: right;'><?php echo $userLoggedIn; ?></div>
                </div><br> 
          
            <div id='out' class='messagehistory'>          
                <!-- loads in dynamicallly -->
            </div>

            <div class="messenger">
                <form class="message_form" action="/profile" method="POST" onsubmit="submitdata(); $('.message_form')[0].reset(); return false;"> 
                    <div class="toRecipient" style="display: none;">
                        <div class="recipientInput">
                            To: <input id="recipient" type="text" name="recipient_username" placeholder="Recipient username" value ="<?php
                            if(isset($_SESSION['recipient_username']))
                            { echo $_SESSION['recipient_username']; } else {echo ""; } ?>"
                            required>
                        </div>
                    </div><br>
                    <input type="text" class="message_textarea" id="message_body" name="message_textarea" onkeypress="return sendForm(e);" placeholder="Send a message." required>
                    <input type="submit" name="message_button" value="Send">
                    <br>
                </form>
            </div>

        </div>   
    </div>
        

    </section>
               
</div>

<?php
include 'footer.php';
?>    

</body>
</html>