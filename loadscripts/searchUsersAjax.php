<?php
require '../config/config.php';

if(isset($_POST['searchTerm'])) {
        $searchTerm = strip_tags($_POST['searchTerm']);
        $searchTerm = str_replace(' ', '', $searchTerm);
        $_SESSION['searchTerm'] = $searchTerm;
}
?>