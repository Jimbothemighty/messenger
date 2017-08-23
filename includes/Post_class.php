<?php
class Post {
    private $user_obj;
    private $connection;
    
    public function __construct($connection, $user){
        $this->connection = $connection;  /* this->connection means, this class's private variable $connection (delared at the top) is equal to the $connection variable logged in. They don't need to have the same name since they are not the SAME variable, but they conventionally are named in this fashion. */
        $this->user_obj = new User($connection, $user);
    }
    
    public function submitPost($body, $user_to) {
        $body = strip_tags($body);
        $body = mysqli_real_escape_string($this->connection, $body);
        //$check_empty = preg_replace('/\s+', '', $body); // Deletes all spaces
        
        echo "<script>console.log('**submitPost function running');</script>";
        echo "<script>console.log('Body text is: " . $body . "');</script>";
        echo "<script>console.log('User to text is: " . $user_to . "');</script>";
        echo "<script>console.log('----------------------------------------');</script>";
        
        
        if($body != '') {
            $date_added = date("Y-m-d H:i:s");
            $added_by = $this->user_obj->getUsername();
            $user_to = $added_by;
            
            $get_posts_query = mysqli_query($this->connection, "SELECT * FROM posts WHERE added_by='$added_by'"); 
            $posts_array = mysqli_fetch_assoc($get_posts_query);
            $num_rows = mysqli_num_rows($get_posts_query);
            
            echo "<script>console.log('Num of rows (user posts):" . $num_rows . "');</script>";
            $user_post_id = $num_rows;
            $user_post_id++;
            echo "<script>console.log('This post_user_id:" . $user_post_id . "');</script>";
            echo "<script>console.log('----------------------------------------');</script>";
            echo "<script>console.log('**Made it to the 2nd part of submitPost function');</script>";
            echo "<script>console.log('Post details are:');</script>";
            echo "<script>console.log('Body:" . $body . "');</script>";
            echo "<script>console.log('Date added:" . $date_added . "');</script>";
            echo "<script>console.log('Added by:" . $added_by . "');</script>";
            echo "<script>console.log('User to:" . $user_to . "');</script>";
            echo "<script>console.log('----------------------------------------');</script>";
            
            mysqli_free_result($result);
            
            if($user_to == $added_by ) {
                $user_to = 'none';
                echo "<script>console.log('User To:" . $user_to . "');</script>";
            }
            else {
                echo "<script>console.log('User To:" . $user_to . "');</script>";
            }    
                
            $query_post = mysqli_query($this->connection, "INSERT INTO posts VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$user_post_id' )");

            $returned_id = mysqli_insert_id($this->connection);

            //Insert notification

            //Update post count for user
            $numPosts = $this->user_obj->getNumPosts();
            $numPosts++;
            echo "<script>console.log('Incremented numPosts = " . $numPosts . "')</script>";
            
            $update_num_posts_query = mysqli_query($this->connection, "UPDATE users SET num_posts='$numPosts' WHERE username = '$added_by'");
            }
            else {
                echo "<script>console.log('submitPost did NOT submit anything to MYSQL');</script>";
            } 
        }
    
    public function getUserPosts ($username) {  
        echo "<script>console.log('getUserPosts function running');</script>";
        echo "<script>console.log('Username to get posts for is:" . $username . "');</script>";
        $query = mysqli_query($this->connection, "SELECT * FROM posts WHERE added_by='$username'");  
        $posts_array = mysqli_fetch_array($query);
        return $posts_array;
    }
}
?>