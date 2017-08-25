<?php
    //require 'includes/User_class.php';

    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Europe/London");

    $connection = mysqli_connect("localhost", "root", "root", "soc_net"); // connection variable
    $conn_array = array();
?>


<?php 
    $searchTerm = $_SESSION['searchTerm'];

    $user_list_query = mysqli_query($connection, "SELECT * FROM users WHERE (username LIKE '%".$searchTerm."%') OR (first_name LIKE '%".$searchTerm."%') OR (last_name LIKE '%".$searchTerm."%')");

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
            
            
                if ($user_array['id'] != NULL)  {
                ?>

                    <script>
                    // TODO - move script to messenger.js
                    // TODO - this is a bit hacky. There's something wrong with the php variable I'm submitting as a string. For some reason it has a space " " at the start. But if I delete it, I get an error. Currently I'm deleting the space in php in messageAjax.php, which is where this is submitting to. 
                    var inputElement = document.createElement('input');
                    inputElement.type = "button";
                    inputElement.value = '\ <?php echo  $fullName . ' (Username: ' . $userSelected . ')'; ?>';
                    inputElement.addEventListener('click', function(){
                        chatWithUser('\ <?php echo $userSelected; ?>');
                    });

                    document.getElementById("userSearchResults").appendChild(inputElement);
                    </script>

                <?php
                }
                else {
                    //echo "<br>Row is missing data.<br>";
                }
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

