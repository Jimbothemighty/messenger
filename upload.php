<?php

// TODO - see if I need to sanitise filenames for the upload

ob_start();
session_start();
$connection = mysqli_connect("localhost", "root", "root", "soc_net");
$userLoggedIn = $_SESSION['username'];

echo "Upload image script is running...<br>";

$target_dir = "assets/images/profilepic/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$pic_name = $_FILES["fileToUpload"]["name"];
// Check if image file is a actual image or fake image
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
    
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
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

$query = mysqli_query($connection, "UPDATE users SET profile_pic='assets/images/profilepic/$pic_name' WHERE username='$userLoggedIn'");


if($uploadOk == 1) {
    header("Location: /messenger/profile.php");
}
else {
    echo 'Upload image failed. Please try again later.<br>';
}

?>