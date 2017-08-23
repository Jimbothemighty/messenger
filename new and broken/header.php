<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo get_bloginfo( 'description' ); ?>">
    <meta name="author" content="">

    <title><?php echo get_bloginfo( 'name' ); ?></title>

    <!-- Custom styles for this template -->

<link href="<?php echo get_bloginfo( 'template_directory' );?>/style.css" rel="stylesheet">
<link href="<?php echo get_bloginfo( 'template_directory' );?>/style-hacks.css" rel="stylesheet">
<link href="<?php echo get_bloginfo( 'template_directory' );?>/assets/css/reg_style.css" rel="stylesheet">
<link href="<?php echo get_bloginfo( 'template_directory' );?>/assets/css/profile_style.css" rel="stylesheet">
<link href="<?php echo get_bloginfo( 'template_directory' );?>/assets/css/messenger_style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script src="<?php echo get_bloginfo( 'template_directory' );?>/assets/js/jQuery3.2.1.js"></script>
<script src="<?php echo get_bloginfo( 'template_directory' );?>/assets/js/nav.js"></script>
<script src="<?php echo get_bloginfo( 'template_directory' );?>/assets/js/parallax.js"></script>




      
      
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<?php wp_head();?>

  </head>

<body>

    <div>
<div class="topNavMenu" id="wp_TopNavMenu">
    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
        <a href="javascript:void(0);" class="icon" onclick="switchNavCss()">&#9776;</a>
</div>
    </div>

<?php
$defaultTitle = get_bloginfo( 'name' );
$defaultTitleUrl = get_bloginfo( 'wpurl' );
$defaultSubTitle = get_bloginfo( 'description' );
$currentPage = $_SERVER['REQUEST_URI'];
if (!($_SERVER['REQUEST_URI'] == '/' || '/register')) {
    echo '<div class="header">';
    echo '<h1><a href="' . $defaultTitleUrl . '">' . $defaultTitle . '</a></h1>
	<p>' . $defaultSubTitle . '</p>';
    echo '</div>';
}
?>