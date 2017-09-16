<?php

require 'config/config.php';

if(!($_SESSION['username'] == "edbrown")) {
    echo "Access denied.";
    exit;
    }

include 'header.php';

?>

<div style="padding-top: 50px; margin-left: 20px;">
<p>
Welcome to the admin dashboard.
</p>

<h2 style="margin-left: 20px">This session data (Unformatted):</h2><br>

<?php
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
?>
    
<br>
<h2 style="margin-left: 20px">All session data:</h2>
    


</div>

<?php
include 'footer.php';
?>    

</body>
</html>