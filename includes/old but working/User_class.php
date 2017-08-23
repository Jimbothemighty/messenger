<?php
class User {
    private $user;
    private $connection;
    
    public function __construct($connection, $user){
        $this->connection = $connection;  /* this->connection means, this class's private variable $connection (delared at the top) is equal to the $connection variable logged in. They don't need to have the same name since they are not the SAME variable, but they conventionally are named in this fashion. */
        $userDetails = mysqli_query($connection, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_assoc($userDetails);
    }
    
    public function getUsername() {
        return $this->user['username'];
    }
    
    public function getNumPosts() {
        $username = $this->user['username'];
        $query = mysqli_query($this->connection, "SELECT * FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        
        echo "<script>console.log('----------------------------------------');</script>";
        echo "<script>console.log('getNumPosts(): getNumPosts function running');</script>";
        echo "<script>console.log('getNumPosts(): Username: " . $username . "');</script>";
        echo "<script>console.log('getNumPosts(): Num of posts: " . $row['num_posts'] . "');</script>";
        
        return $row['num_posts'];
    }
    
    public function getFirstAndLastName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->connection, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_assoc($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
}