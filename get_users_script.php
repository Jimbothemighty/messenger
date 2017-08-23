<?php
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Europe/London");

    $connection = mysqli_connect("localhost", "root", "root", "soc_net"); // connection variable
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
?>


<?php 
        
    $user_list_query = mysqli_query($connection, "SELECT * FROM users");
        
        $num_rows = mysqli_num_rows($user_list_query);      
        $w = $num_rows;     
        
        $first_row=mysqli_fetch_row($user_list_query);
        $j = $first_row['0'];
        
        $x = $w-1; /* amount to move pointer by */
        mysqli_data_seek ($user_list_query,$x);      
        $last_row = mysqli_fetch_row($user_list_query);
        $i = $last_row['0']; /* index 0 is the id */
        mysqli_free_result($result);

        $a = 0;

        echo "<script>console.log('-----------------------------------------');</script>";
        echo "<script>console.log('Number users total (w): " . $w . "');</script>";
        echo "<script>console.log('Index (ID) of first stored user (should be 1): (j) " . $j . "');</script>";
        echo "<script>console.log('Index (ID) of last stored user (i): " . $i . "');</script>";
        echo "<script>console.log('-----------------------------------------');</script>";

        // load all users
        for($j; $j <= $i; $j++) {
            mysqli_data_seek ($user_list_query,$a);      
            $user_array = mysqli_fetch_assoc($user_list_query);
            $whatever_p_is = mysqli_fetch_row($user_list_query);
            //$userRow = $user_array['username'];
            //$userSelected = new User($connection, $userRow);
            
                if ($user_array['id'] != NULL)  {
                    echo "<input type='submit' class='userResult' style='width: 100%; background-color: black; text-align: left;' onclick='chatWithUser(); return false;' value='";
                    //echo $userSelected->getUsername();
                    echo "<br>";
                    //echo $userSelected->getFirstAndLastName();
                    //echo "User ID: " . $user_array['id'] . " | ";
                    //echo $user_array['first_name'] . " " . $user_array['last_name'] . " | ";
                    //echo $userToChatWith . " | ";
                    //echo "Click/Tap to chat";
                    echo "'><br>";
                    
                }
                else {
                    echo "<br>Row is missing data.<br>";
                }
                //mysqli_free_result($result);
            $a++;
        }
        
?>
<script>
function chatWithUser() {
        <?php
        $_SESSION['recipient_username'] = $userSelected;
        ?>
        console.log('<?php echo $_SESSION['recipient_username']; ?>')
    };
</script>

