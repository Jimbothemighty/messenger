<?php
ob_start();
session_start();  

header("Cache-Control: no-cache");
header("Pragma: no-cache");

header("Access-Control-Allow-Origin: *");

if(isset($_POST['searchTerm'])) {
        $searchTerm = strip_tags($_POST['searchTerm']);
        $searchTerm = str_replace(' ', '', $searchTerm);
        $_SESSION['searchTerm'] = $searchTerm;
}
?>