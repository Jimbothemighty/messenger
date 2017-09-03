<?php
require 'config/config.php';

header("Cache-Control: no-cache");
header("Pragma: no-cache");

header("Access-Control-Allow-Origin: *");
require 'includes/reg_handler.php';
require 'includes/login_handler.php';

require 'includes/User_class.php';
require 'includes/Post_class.php';

include 'header.php';

    echo "<script>console.log('get_conversatons; Session User is: " . $userLoggedIn . "');</script>";
    echo "<script>console.log('get_conversatons; Session ID is: "  . session_id() . "');</script>";
?>
<div style="background-color: dodgerblue; max-width: 1500px; margin-left: auto; margin-right: auto; padding: 50px; box-sizing: border-box; padding-top: 100px; min-height: 100%;">
    <h1><u>Roadmap</u></h1>
    <p>
        This is the webpage for listing features under development as well as detailing current bugs in the program that are being addressed.
    </p>
    
    <div id="concurrentSessions">
        <div style="height: 0px; width: 80%; border: 1px solid white; margin: 0 auto; margin-bottom: 40px;"></div>
        <h2><u>Concurrent Sessions Bug</u></h2>
        <h3>(03/09/2017) Problem: Ajax requsts for information show unique session_id() and no stored session variables.</h3>

        <p>I am new to working with sessions and this is a confusing problem for me. Stackoverflow questions and respones regarding ajax not having the session variable invariably discuss missing session_start() on the ajax pages. But that is not the issue here.</p>

        <p>The web application works more or less perfectly for a user logged in (disregarding minor bugs). However, this issue is driving me nuts. The problem occurs when concurrent sessions are created on thesame machine (same browser?). There is no problem, so long as only one tab on a browser is being used to log in and log out.</p>

        <p>However, if the browser tab is left logged in open and running (OR even if it is left logged in but closed I think!) and then the application is opened in a second browser tab (or even a different browser?), two instances of session_id() exist concurrently.</p>

        <p>This is a problem because when an ajax request is made and the page is not navigated to directly, the ajax request does not know which session to work with, and so creates a new session_id() on each occasion that the script is called! I THINK this process is called serialisation.</p>

        <p>Currently once this bug has been initiated you have to wait for the sessions to expire, which takes hours! I probably do want concurrent sessions to be possible, but the nature of the ajax session_id problem makes this impossible.</p>

        <p>Also most importantly this is BREAKING website functionality with no resolution for the users.</p>

        <p>I have not figured out the solution so far, but areas to look at to fix the problem of concurrent sessions are:</p>
        <ul>
            <li>The php manual discusses that session_id() is not unset on session_destroy(). (Although I think I AM unsetting this manually)</li>
            <li>Using session_regenerate_id()</li>
            <li>Using session_commit()</li>
            <li>Check what setcookie() is doing. Maybe this behaviour will have something to do with it.</li>
            <li>Use memcache or some other session handler.</li>
            <li>Set lifespan of session information to expire as soon as user nagivates away from page.</li>
            <li>When login button is clicked, check if a session already exists when logging in. If it does, adopt the session_id that is pre-existing</li>
            <li>When trying to view the login page, redirect to profile page to prevent concurrent logins on the browser <u>(I think this one might work!)</u></li>
        </ul>
        <div style="height: 0px; width: 80%; border: 1px solid white; margin: 0 auto; margin-top: 40px;"></div>
    </div>

</div>




<?php
include 'footer.php';
?>    

</body>
</html>