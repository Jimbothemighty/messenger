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

    <!-- Custom styles for this template -->

<link href="http://localhost/messenger/style.css" rel="stylesheet">
<link href="http://localhost/messenger/assets/css/reg_style.css" rel="stylesheet">
<link href="http://localhost/messenger/assets/css/profile_style.css" rel="stylesheet">
<link href="http://localhost/messenger/assets/css/messenger_style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://localhost/messenger/assets/js/jQuery3.2.1.js"></script>
<script src="http://localhost/messenger/assets/js/nav.js"></script>
<script src="http://localhost/messenger/assets/js/parallax.js"></script>

    <style>
        html,body{height:100%;}
        .wrapper{min-height:100%; position:relative}
        .full{position:absolute; top:0; left:0; width:100%; height:100%;}
    </style>
      
    <script>         
    function noPasteAlert() {
    document.getElementById("alert").style.display='block';
    }
    </script>

    <script>
    $(document).ready(function() {
        console.log( "document loaded" );
        
        $("#scrollButton").click(function scrollContent() {
            /* var x = document.getElementById("middle"); */
            /* x.scrollIntoView({ block: "start", behavior: "smooth" }); */
            $('html, body').animate({scrollTop: $('#middle').offset().top -50 }, 'slow');
        });
    });
    </script>
      
    <script>
    $(document).ready(function(){
      refreshTable();
    });

    function refreshTable(){
        $(".messengerscript").load("messenger/includes/messenger_script.php", function( response, status, xhr ) {
              if ( status == "error" ) {
                var msg = 'Loading messenges resulted in an error: ';
                console.log(msg + xhr.status + " " + xhr.statusText );
              } else {
                setTimeout(refreshTable, 4000);
                console.log('messenger loader is ticking every 5 seconds')
                /* displayNotification($('#messenger_script')); */
              }
        });
    }
    </script>
<!--
<script type="text/javascript">// <![CDATA[
$(document).ready(function() {
$.ajaxSetup({ cache: false }); // This part addresses an IE bug. without it, IE will only load the first number and will never refresh
setInterval(function() {
$('.messenger_script').load('messenger_script.php');
}, 2000); // the "3000" here refers to the time to refresh the div. it is in milliseconds.
});
// ]]></script>
-->              
   <script>
        $(document).ready(function() {
            if($(".topNavMenu").offset().top === 0 && $(window).width() > 768 && top.location.pathname === '/') {
            $(".topNavMenu").css("background-color", "transparent");
            }
            else {
                $(".topNavMenu").css("background-color", "#333");
            } 
        });

        $(document).scroll(function() {
            if($(".topNavMenu").offset().top === 0 && $(window).width() > 768 && top.location.pathname === '/') {
            $(".topNavMenu").css("background-color", "transparent");
            }
            else {
                $(".topNavMenu").css("background-color", "#333");
            }
        });
        $(window).resize(function() {
            if($(".topNavMenu").offset().top === 0 && $(window).width() > 768 && top.location.pathname === '/') {
            $(".topNavMenu").css("background-color", "transparent");
            }
            else {
                $(".topNavMenu").css("background-color", "#333");
            }
        });  
    </script>
      
        <?php  
        if(isset($_SESSION['username'])) {
            echo "<script>document.getElementById('logout').style.display='block';</script>";
            //document.getElementById("logout").style.display='block';
            console.log('logout link display is active');
            echo "<script>console.log('logout link display is active');</script>";
        }
        else {
            echo "<script>document.getElementById('logout').style.display='none';</script>";
            //document.getElementById("logout").style.display='none';
            echo "<script>console.log('logout link is disabled');</script>";
        }
        ?>
    
<!--
        <script>
        jQuery( document ).ready(function() {
        console.log( "document loaded" );
            jQuery(".parallax-title-text").on("swipe", scrollContent(swipeleft) {
                jQuery('html, body').animate({scrollTop: jQuery('#middle').offset().top-50}, 'slow');
            });                                         
        });
        
      </script>
-->

      
      
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	

  </head>

<body>

    <div>
<div class="topNavMenu" id="wp_TopNavMenu">
        <a href="profile.php">Profile</a>
        <a href="register.php">Register</a>
        <a href="logout.php">Log out</a>
        <a href="javascript:void(0);" class="icon" onclick="switchNavCss()">&#9776;</a>
</div>
    </div>
