<?php
ob_start();
session_start();

?>

                <form class="message_form" action="/profile" method="POST" onsubmit="submitdata(); $('.message_form')[0].reset(); return false;"> 
                    <div class="toRecipient">
                        <div class="recipientInput">
                            To: <input id="recipient" type="text" name="recipient_username" placeholder="Recipient username" value ="<?php
                            if(isset($_SESSION['recipient_username']))
                            { echo $_SESSION['recipient_username']; } else {echo ""; } ?>"
                            required>
                        </div>
                    <input type="submit" name="message_button" value="Send"></div><br>
                    <textarea type="text" class="message_textarea" id="message_body" name="message_textarea" placeholder="Send a message." required></textarea><br>
                </form>