<?php
ob_start();
session_start();  

if(isset($_POST['searchTerm'])) {
        $searchTerm = strip_tags($_POST['searchTerm']);
        $searchTerm = str_replace(' ', '', $searchTerm);
        $_SESSION['searchTerm'] = $searchTerm;
}
?>

<script>console.log('<?php echo $searchTerm; ?>)'</script>