<?php

header("Access-Control-Allow-Origin: *");

ob_start();
session_start([
    'cookie_lifetime' => 86400,
]);

$timezone = date_default_timezone_set("Europe/London");

//ONLINE CONNECTION VARIABLE
    $connection = mysqli_connect("better-planet.org", "superBasic", "juniper1234", "soc_net");

//OFFLINE CONNECTION VARIABLE

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