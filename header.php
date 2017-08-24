<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Messenger Web Application">
    <meta name="author" content="">

    <title>Messenger Web Application</title>

    <link href="http://localhost/messenger/style.css" rel="stylesheet">
    <link href="http://localhost/messenger/assets/css/reg_style.css" rel="stylesheet">
    <link href="http://localhost/messenger/assets/css/profile_style.css" rel="stylesheet">
    <link href="http://localhost/messenger/assets/css/messenger_style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://localhost/messenger/assets/js/jQuery3.2.1.js"></script>
    <script src="http://localhost/messenger/assets/js/nav.js"></script>
    <script src="http://localhost/messenger/assets/js/messenger.js"></script>

      <!-- this is needed to full page the register.php page. TODO - move this to reg_style or style.css -->
    <style>
        html,body{height:100%;}
        .wrapper{min-height:100%; position:relative}
        .full{position:absolute; top:0; left:0; width:100%; height:100%;}
    </style>
    
      <!-- TODO - move this to a .js file -->
    <script>         
    function noPasteAlert() {
    document.getElementById("alert").style.display='block';
    }
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    </head>
<body>

<div class="topNavMenu" id="wp_TopNavMenu">
    <a href="profile.php">Profile</a>
    <a href="register.php">Register</a>
    <a href="logout.php">Log out</a>
    <a href="javascript:void(0);" class="icon" onclick="switchNavCss()">&#9776;</a>
</div>