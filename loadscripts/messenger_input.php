<?php
require '../config/config.php';
?>

                <form class="message_form" action="/profile" method="POST" onsubmit="submitdata(); $('.message_form')[0].reset(); return false;"> 
                    <div class="toRecipient" style="display: none; height: 0px; width: 0px;">
                        <div class="recipientInput">
                            To: <input id="recipient" type="text" name="recipient_username" placeholder="Recipient username" value ="<?php
                            if(isset($_SESSION['recipient_username']))
                            { echo $_SESSION['recipient_username']; } else {echo ""; } ?>"
                            required>
                        </div>
                    </div><br>
                    <div>
                    <input type="text" class="message_textarea" id="message_body" name="message_textarea" placeholder="Send a message." style="float: left;" required>
                    <input id="submit_message" type="submit" name="message_button" value="Send">
                    </div>
                </form>