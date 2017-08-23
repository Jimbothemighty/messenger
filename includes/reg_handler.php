<?php

// Delcaring variables to prevent errors
$fname = "";
$lname = "";
$em = "";
$em2 = "";
$pw = "";
$pw2 = "";
$date = "";
$error_array = array();
$session_array = array();

if(isset($_POST['register_button'])) {
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;
    
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;
    
    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ', '', $em);
    $_SESSION['reg_email'] = $em;
    
    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ', '', $em2);
    $_SESSION['reg_email2'] = $em2;
    
    $pw = strip_tags($_POST['reg_password']);
    $pw2 = strip_tags($_POST['reg_password2']);
    $_SESSION['reg_password'] = $pw;
    $_SESSION['reg_password2'] = $pw2;
    
    $date = date("Y-m-d");   

// POST VALIDATION
    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters in length.<br>");
    }
    
    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters in length.<br>");
    }
    
    
    if($em == $em2) {
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);
        }
        else { array_push($error_array, "Invalid email format.<br>"); }   
    }
    else { array_push($error_array, "Emails do not match.<br>"); }

    // Check if email already exists
    $e_check = mysqli_query($connection, "SELECT email FROM users WHERE email='$em'");
    $num_rows = mysqli_num_rows($e_check);

    if($num_rows > 0) {
        array_push($error_array, "This email address is already in use.<br>");
    }
    
    if(preg_match('/[^A-Za-z0-9]/', $pw)) {
        array_push($error_array, "Your password can only contain characters from the English Alphabet or numbers.<br>");
    }
    
    if(strlen($pw > 20 || strlen($pw) < 8)) {
        array_push($error_array, "Your password is of an invalid length. Please select a password between 8 and 20 characters in length.<br>");
    }  elseif($pw != $pw2) {
        array_push($error_array, "Passwords do not match.<br>");
    }
       
    
    if(empty($error_array)) {
        echo "<script>console.log('Error log is empty on register button pushed');</script>";
        
        $_SESSION['$reg_fname'] = "";
        $_SESSION['$reg_lname'] = "";
        $_SESSION['$reg_email'] = "";
        $_SESSION['$reg_password'] = "";
        $_SESSION['$reg_email2'] = "";
        $_SESSION['$reg_password2'] = "";
        
        array_push($session_array, $_SESSION['$reg_fname']);
        array_push($session_array, $_SESSION['$reg_lname']);
        array_push($session_array, $_SESSION['$reg_email']);
        array_push($session_array, $_SESSION['$reg_password']);
        array_push($session_array, $_SESSION['$reg_email2']);
        array_push($session_array, $_SESSION['$reg_password2']);        
        
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        
        // generate username
        $username = strtolower($fname . $lname);
        $check_username = mysqli_query($connection, "SELECT username FROM users WHERE username='$username'");
        
        $i = 0;
        while(mysqli_num_rows($check_username) != 0) {
        $i++;
        $username = $username . $i;
        $check_username = mysqli_query($connection, "SELECT username FROM users WHERE username='$username'");
        }
    
        $profile_pic = 0;
        $query = mysqli_query($connection, "INSERT INTO users VALUES (NULL, '$fname', '$lname', '$username', '$em', '$pw', '$date', '$profile_pic', '0', '0', 'no', ',')");
        
        $e_check = mysqli_query($connection, "SELECT email FROM users WHERE email='$em'");
        $num_rows = mysqli_num_rows($e_check);
        
        if($num_rows > 0) {
        array_push($error_array, '<span style="color:green;">Registration completed successfully, please log in.</span><br>');
        }
        else { array_push($error_array, '<span style="color:red;">Registration Error. There has been an error. Your details have not been registered on the website.</span><br>');
        }
    
        // Empty the session variables
        
        $_POST = array();
        }
    
}
?>