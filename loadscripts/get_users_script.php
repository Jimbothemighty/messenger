<?php
    require '../includes/User_class.php';
    require '../config/config.php';

    echo '<script>console.log("Get search results script is running...");</script>';

        $searchTerm = $_SESSION['searchTerm'];
        echo "<script>console.log('from inside get_users_script():" . $_SESSION['searchTerm'] . "')</script>";
        echo "<script>console.log('from inside get_users_script():" . $searchTerm . "')</script>";
        if($searchTerm == "") { echo "Sorry there has been an error!"; return; }

        $user_list_query = mysqli_query($connection, "SELECT * FROM users WHERE (username LIKE '%".$searchTerm."%') OR (first_name LIKE '%".$searchTerm."%') OR (last_name LIKE '%".$searchTerm."%') ORDER BY id ASC");

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

        if ($userLoggedIn == "") {
            echo "<p>User session needs to be refreshed. This script does not recognise a logged in user.</p>";
            return;
        }

        echo '<form id="getContacts" action="profile.php" method="POST" onsubmit="return false;">';
        echo '<div id="userSearchResults">';
        // load all users
        for($j; $j <= $i; $j++) {
            mysqli_data_seek ($user_list_query,$a);      
            $user_array = mysqli_fetch_assoc($user_list_query);
            $whatever_p_is = mysqli_fetch_row($user_list_query);
            //$userRow = $user_array['username'];
            //$userSelected = new User($connection, $userRow);
            //$userSelected = $user->getFirstAndLastName();
            $userSelected = $user_array['username'];
            $fullName = $user_array['first_name'] . ' ' . $user_array['last_name'];
            
            if($num_rows < 1) { echo "<P>Sorry, no results matched your query.</P>"; return; }
                if ($user_array['id'] != NULL)  {
                    if($user_array['username'] != $userLoggedIn) {
                        $userCl = new User($connection, $userSelected);
                        ?>
                            <div id="results_button" onclick="chatWithUser('\ <?php echo $userSelected; ?>')">
                    
                                <div id="results_image" style="background-image: url('<?php echo $userCl->getUserProfilePic(); ?>')"></div>

                                <?php
                                echo  $fullName . '<br>Username: ' . $userSelected  
                                ?>    
                            </div>
                        <?php
                    }
                }
                else {
                    //echo "<br>Row is missing data.<br>";
                }
                //mysqli_free_result($result);
            $a++;
        }
        echo '</form>';
        echo '<br>';
?>

