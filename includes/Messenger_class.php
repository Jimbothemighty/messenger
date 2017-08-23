<?php
//require 'config/config.php';
//require 'includes/User_class.php';
//require 'includes/Post_class.php';
//require 'messageAjax.php';

class Messenger {
    private $user_obj;
    private $connection;
    
    public function __construct($connection, $user){
        $this->connection = $connection;  /* this->connection means, this class's private variable $connection (delared at the top) is equal to the $connection variable logged in. They don't need to have the same name since they are not the SAME variable, but they conventionally are named in this fashion. */
        $this->user_obj = new User($connection, $user);
    }

    
    public function submitMessage($body, $user_to) {
        $body = strip_tags($body);
        $body = mysqli_real_escape_string($this->connection, $body);
        //$check_empty = preg_replace('/\s+', '', $body); // Deletes all spaces
        
        echo "<script>console.log('**submitMessage function running');</script>";
        echo "<script>console.log('Body text is: " . $body . "');</script>";
        echo "<script>console.log('User to text is: " . $user_to . "');</script>";
        echo "<script>console.log('----------------------------------------');</script>";
        
        
        if($body != '') {
            $date_added = date("Y-m-d H:i:s");
            $added_by = $this->user_obj->getUsername();
            //$user_to = $added_by;
            
            $get_messages_query = mysqli_query($this->connection, "SELECT * FROM messenger WHERE added_by='$added_by'"); 
            $messages_array = mysqli_fetch_assoc($get_messages_query);
            $num_rows = mysqli_num_rows($get_messages_query);
            
            echo "<script>console.log('Num of rows (user posts):" . $num_rows . "');</script>";
            //$user_messages_id = $num_rows;
            $user_messages_id = 0;
            echo "<script>console.log('This post_user_id:" . $user_messages_id . "');</script>";
            echo "<script>console.log('----------------------------------------');</script>";
            echo "<script>console.log('**Made it to the 2nd part of submitPost function');</script>";
            echo "<script>console.log('Post details are:');</script>";
            echo "<script>console.log('Body:" . $body . "');</script>";
            echo "<script>console.log('Date added:" . $date_added . "');</script>";
            echo "<script>console.log('Added by:" . $added_by . "');</script>";
            echo "<script>console.log('User to:" . $user_to . "');</script>";
            echo "<script>console.log('----------------------------------------');</script>";
            
            if($user_to == $added_by ) {
                $user_to = 'none';
                echo "<script>console.log('User To:" . $user_to . "');</script>";
            }
            else {
                echo "<script>console.log('User To:" . $user_to . "');</script>";
            }    
                
            $query_messages = mysqli_query($this->connection, "INSERT INTO messenger VALUES (NULL, '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$user_messages_id' )");
        }
    }
    
    public function getUserMessages ($username) {  
        echo "<script>console.log('getUserMessages function running');</script>";
        echo "<script>console.log('Username to get messages for is:" . $username . "');</script>";
        $query = mysqli_query($this->connection, "SELECT * FROM messenger WHERE added_by='$username'");  
        $messages_array = mysqli_fetch_array($query);
        return $messages_array;
    }
}
?>