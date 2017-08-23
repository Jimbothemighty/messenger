<?php

$success_login_array = array();

if(isset($_POST['login_button'])) {
    
    $email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['login_password'];
    
    $check_database_query = mysqli_query($connection, "SELECT username, email, password FROM users WHERE email='$email'");
    
    $check_login_query = mysqli_num_rows($check_database_query);
    
    if($check_login_query > 0) {
        array_push ($success_login_array, 'Found email address in DB table.<br>');
        
        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];
        $email = $row['email'];
        $hashedPassword = $row['password'];
        
        if(password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            array_push ($success_login_array, 'Login successful.<br>');
            header("Location: /profile");
            exit();
        }
    }
}
?>