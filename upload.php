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
    top: 33%;
    width: 100%;
    height: 33%;
    padding: 10px;
    text-align: center;
    font-size: 8rem;
}
</style>

<?php

// TODO - see if I need to sanitise filenames for the upload

require 'config/config.php';

ini_set('max_execution_time', 2500);

echo "Upload image script is running...<br>";

$target_dir = "assets/images/profilepic/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$pic_name = $_FILES["fileToUpload"]["name"];
// Check if image file is a actual image or fake image

$reason = "";

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
        echo "<script type='text/javascript'>alert('Sorry, this upload failed because this file was not recognised as an image.');</script>";
        $uploadOK = 0;
    }
}

// Check file size [currently 5MB limit (5,000,000 bytes)]
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large (Max file size for upload is 5MB. Please select another file.<br>";
    echo "<script type='text/javascript'>alert('Sorry, your file is too large (Max file size for upload is 5MB. Please select another file.');</script>";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    echo "<script type='text/javascript'>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
    $uploadOk = 0;
}

// Check if file already exists
    echo "<script type='text/javascript'>alert('A file with this name already exists.');</script>";
    echo "A file with this name already exists.<br>";
    // Setting up variables
    $pic_number = 0;
    $pic_name_no_suffix = pathinfo($target_file, PATHINFO_FILENAME);
    $suffix = pathinfo($target_file, PATHINFO_EXTENSION);
    
    while(file_exists($target_file)) {
    echo "<script type='text/javascript'>alert('Attempting to rename file (Attempt: $pic_number)');</script>";
    echo "Attempting to rename file.<br>";
    // TODO - FIGURE OUT HOW TO USE MB_SUBSTR (for characters larger than 1 byte)
        $new_pic_name = "";
        $pic_number++;
        
        $new_pic_name = $pic_name_no_suffix . $pic_number . "." . $suffix;
        
        $target_file = $target_dir . basename($new_pic_name);
    }

$pic_name = $new_pic_name;


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
    echo '<div id="loadingOverlay" style="display: block;"><A HREF="/messenger/profile.php"><button>Return to profile.</button></A></div>';
}
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        header("Location: profile.php");
    }
    else {
        echo "Sorry, your file passed our checks, but there was an error uploading the file to the server. The problem is out our end, please try again later.<br>";
        echo "<script type='text/javascript'>alert('Sorry, your file passed our checks, but there was an error uploading the file to the server. The problem is out our end, please try again later.');</script>";
    }
}

$query = mysqli_query($connection, "UPDATE users SET profile_pic='$target_file' WHERE username='$userLoggedIn'");


if($uploadOk == 1) {
    exit();
}
else {
    exit();
}

?>