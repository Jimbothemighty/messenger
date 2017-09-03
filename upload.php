<style>
#loadingOverlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 3;
    cursor: pointer;
}

button {
    position: fixed;
    top: 48%;
    left: 45%;
    width: 200px;
    height: 80px;
    padding: 10px;
}
</style>

<?php

// TODO - see if I need to sanitise filenames for the upload

ob_start();
session_start();
$connection = mysqli_connect("better-planet.org", "superBasic", "juniper1234", "soc_net");
$userLoggedIn = $_SESSION['username'];

ini_set('max_execution_time', 500);

echo "Upload image script is running...<br>";

$target_dir = "assets/images/profilepic/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$pic_name = $_FILES["fileToUpload"]["name"];
// Check if image file is a actual image or fake image

if($pic_name == "") {
    $noImageSelected = "You did not select a file.";
    echo "<script type='text/javascript'>alert('$noImageSelected');</script>";
    echo '<div id="loadingOverlay" style="display: block;"><A HREF="/messenger/profile.php"><button>Return to profile.</button></A></div>';
    exit();
}

if(isset($_POST["upload_profilepic"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . "...<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}
// Check if file already exists
    // Setting up variables
    $x = mb_strlen($pic_name);
    $pic_number = 0;

while(file_exists($target_file)) {
ini_set('max_execution_time', 500);
    
// TODO - FIGURE OUT HOW TO USE MB_SUBSTR (for characters larger than 1 byte)
    $new_pic_name = "";
    $v = 0;
    $pic_number++;

    // Get number of chars in pic_name up until suffix begins
    while($pic_name[$v] != ".") {
    $v++;
    }

    $last_chars = $x - $v;  // last chars might not be needed!!! **********************************
    $w = $v;                // w is used for reattaching file type later

    // Recreating filename by looping through chars in strings (without suffix)
    for ($y = 0; $y < ($v); $y++) {
        $new_pic_name[$y] = $pic_name[$y];
    }

    // Getting the unique number to add to picture as string and also the strlen for looping
    $pic_num_as_str = strval($pic_number);
    $p_n_strlen = mb_strlen($pic_num_as_str);

    $current_char_plus_num_len = $v + $p_n_strlen; // the index number to loop up until when adding unique number
    $z = 0; // array index starting position for the unique number(string)

    // Attach unique number to new_pic_name
    for ($v; $v < $current_char_plus_num_len; $v++) {
        $new_pic_name[$v] = $pic_num_as_str[$z];
        $z++;
    }

    // Attach file type suffix to new_pic_name
    for ($w; $w < $x; $w++) {
        $new_pic_name[$v] = $pic_name[$w];
        $v++;

    $target_file = $target_dir . basename($new_pic_name);
    }
}

$pic_name = $new_pic_name;

echo $pic_name . "<br>";
    
// Check file size [currently 10MB limit (10,000,000 bytes)]
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    ini_set('max_execution_time', 500);
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    ini_set('max_execution_time', 500);
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}

$query = mysqli_query($connection, "UPDATE users SET profile_pic='$target_file' WHERE username='$userLoggedIn'");


if($uploadOk == 1) {
    //echo 'new picture is: ' . $pic_name;
    //echo 'target_file is: ' . $target_file;
    $succeeded = "Successfully updated your profile picture.";
    echo "<script type='text/javascript'>alert('$succeeded');</script>";
    echo '<div id="loadingOverlay" style="display: block;"><A HREF="/messenger/profile.php"><button>Return to profile.</button></A></div>';
    exit();
}
else {
    echo 'Upload image failed. Please try again later.<br>';
    $failed = "There was an error uploading your image.";
    echo "<script type='text/javascript'>alert('$failed');</script>";
    echo '<div id="loadingOverlay" style="display: block;"><A HREF="/messenger/profile.php"><button>Return to profile.</button></A></div>';
    exit();
}

?>