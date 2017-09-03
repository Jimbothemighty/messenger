<?php

require 'config/config.php';
require 'includes/reg_handler.php';
require 'includes/login_handler.php';
include 'header.php';

?>

<div class="wrapper">
    
<div class="innerWrapper">
    <div id="registerTag"></div>
    <div id="loginDiv">
    <h2>EXISTING USERS:</h2>  
    <form id="loginDiv" action="/messenger/register.php" method="POST">  
        <input type="email" name="login_email" placeholder="Email">
        <br>
        <input type="password" name="login_password" placeholder="Password">
        <br>
        <input type="submit" name="login_button" value="Login">
        <br>
        
        <?php
        if(isset($_POST['login_button'])) {
            if(in_array('Found email address in DB table.<br>', $success_login_array)) {
                echo "<br><p class='outputLog' style='color: green;'>Found email address in DB table.<br></p>";             
            }
            else {
                echo "<p class='outputLog' style='color: red;'>No user found in DB table.<br></p>";              
            }
            
            if(in_array('Login successful.<br>', $success_login_array)) {
                echo "<br><p class='outputLog' style='color: green;'>Login successful.<br></p>";
            }
            else {
                echo "<br><p class='outputLog' style='color: red;'>Login Failed. Password does not match DB.</p><br>";
            }
        }
        ?>
    </form>
    </div>
    
    <div class="lineBreak"></div>
    <div id="registerTag"></div>
    <div id="registerDiv">
    <h2>NEW USERS:</h2>
    <form id="registerDiv" action="/messenger/register.php" method="POST">
        <input type="text" name="reg_fname" placeholder="First Name" value="<?php
        if(isset($_SESSION['reg_fname']))
        { echo $_SESSION['reg_fname']; } else {echo ""; } ?>"
            required>
        <br>
        <?php if(in_array("Your first name must be between 2 and 25 characters in length.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Your first name must be between 2 and 25 characters in length.</div>"; } ?>

        <input type="text" name="reg_lname" placeholder="Last Name" value ="<?php
        if(isset($_SESSION['reg_lname']))
        { echo $_SESSION['reg_lname']; } else {echo ""; } ?>"
            required>
        <br>
        <?php if(in_array("Your last name must be between 2 and 25 characters in length.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Your last name must be between 2 and 25 characters in length.</div>"; } ?>
        
        <input type="email" name="reg_email" placeholder="Email" value ="<?php
        if(isset($_SESSION['reg_email']))
        { echo $_SESSION['reg_email']; } else {echo ""; } ?>"
            required>
        <br>
        <?php if(in_array("Invalid email format.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Invalid email format.</div>"; } ?>
        <?php if(in_array("Emails do not match.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Emails do not match.</div>"; } ?>
        <?php if(in_array("This email address is already in use.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>This email address is already in use.</div>"; } ?>
          
        <input type="email" name="reg_email2" placeholder="Confirm Email" value ="<?php
        if(isset($_SESSION['reg_email2']))
        { echo $_SESSION['reg_email2']; } else {echo ""; } ?>"
            required>
        <br>

        <input type="password" name="reg_password" onpaste="noPasteAlert(); return false;" ondrop="noPasteAlert(); return false;" autocomplete="off" placeholder="Password" required>
        <br>
        
        <div id="alert">
            <div class="closebtn" style="float: right; padding-right: 15px; font-size: 2em;" onclick="this.parentElement.style.display='none';">&times;</div>
            You can't paste into the Password fields.
        </div>
        
        <?php if(in_array("Passwords do not match.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Passwords do not match.</div>"; } ?>
        <?php if(in_array("Your password can only contain characters from the English Alphabet or numbers.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Your password can only contain characters from the English Alphabet or numbers.</div>"; } ?>
        <?php if(in_array("Your password is of an invalid length. Please select a password between 8 and 20 characters in length.<br>", $error_array))
            { echo "<div class='outputLog' style='color: red;'>Your password is of an invalid length. Please select a password between 8 and 20 characters in length.</div>"; } ?>    
        
        <input type="password" name="reg_password2" onpaste="noPasteAlert(); return false;" ondrop="noPasteAlert(); return false;" autocomplete="off" placeholder="Confirm Password" required>   
        <br>
        <input type="submit" name="register_button" value="Register">
        <br>
        <?php
        if(in_array('<span style="color:green;">Registration completed successfully, please log in.</span><br>', $error_array)) {
            echo "<br><div class='outputLog' style='color:green;'>Registration completed successfully, please log in.</div><br>";
        }
        if(in_array('<span style="color:red;">Registration Error. There has been an error. Your details have not been registered on the website.</span><br>', $error_array)) {
            echo "<div class='outputLog' style='color:red;'>Registration Error. There has been an error. Your details have not been registered on the website.</div><br>";
        }
        ?>
    </form>
    </div>
</div> <!-- close innerWrapper -->
</div> <!-- close wrapper -->

<?php
include 'footer.php';
?>

</body>
</html>