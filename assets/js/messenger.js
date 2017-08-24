/* -------------------------------- JQUERY DYNAMIC WINDOW RESIZING FOR MESSAGE HISTORY ---------------------------------- */

jQuery(document).ready(function($) {
    $(".ccContent").height($("body").height()-150);
    $(".messengerDetails").height($("body").height()-150);    
    $(".messagehistory").height($(".messengerscript").height()-230);
    var a = document.getElementById("out");
    a.scrollTop = a.scrollHeight - a.clientHeight;
    console.log('message history / script doc ready function running')
});

$(window).resize(function() {
    $(".ccContent").height($("body").height()-150);
    $(".messengerDetails").height($("body").height()-150);
    $(".messagehistory").height($(".messengerscript").height()-230);
    var a = document.getElementById("out");
    a.scrollTop = a.scrollHeight - a.clientHeight;
    console.log('message history / script window resize function running')
});

/* ----------------------------- END OF JQUERY DYNAMIC WINDOW RESIZING FOR MESSAGE HISTORY ------------------------------- */


/* ----------------------------- sets return/ENTER keypress as a submit button for message_form */
$('.message_form').keydown(function(e) {
var keypress = e.which;
if (keypress == 13) {
$('.message_form').submit();
}
});


/* ----------------------------- submitData() function   This ajax submits new messages sent by userLoggedIn */
function submitdata() {
 var recipient = document.getElementById("recipient").value;
 var messagebody = document.getElementById("message_body").value;

 $.ajax({
  type: 'post',
  url: 'http://localhost/messenger/loadscripts/messageAjax.php',
  data: {
   recipient_username:recipient,
   message_textarea:messagebody,
  },
  success: function (response) {
    console.log('Posting message.');
  }
 });
updateMessages();
}

        
        

/* ----------------------------- scrolls to the bottom of the message history div to ensure looking at the latest messages at the same time it gets the updated message list */
var add;
    
function callRefresh() {
    var add = setInterval(updateMessages, 10000);
    updateMessageHeader();
    // updates the message panel size.
    $(".messengerDetails").height($("body").height()-150);
    $(".messagehistory").height($(".messengerscript").height()-230);
    var a = document.getElementById("out");
    a.scrollTop = a.scrollHeight - a.clientHeight;
}
    
function stopRefresh() {
    clearInterval(add);
}

    
function updateMessages() {        
    $(".messagehistory").load("http://localhost/messenger/loadscripts/messenger_script.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading messenges resulted in an error: ';
             console.log(msg + xhr.status + " " + xhr.statusText );
         }
          else {
            var time;
            var time = new Date();
            var h = time.getHours();
            var m = time.getMinutes();
            var s = time.getSeconds();
            console.log('Update messages is running.',h,':',m,':',s);
            var out = document.getElementById("out");
            var isScrolledToBottom = out.scrollHeight - out.clientHeight < out.scrollTop + 300;
            console.log('Scrolled to:', (out.scrollHeight - out.clientHeight) - out.scrollTop, 'Allowed scroll limit:', 300);
            if(isScrolledToBottom) {
                out.scrollTop = out.scrollHeight - out.clientHeight;
            }
        }
    });
};

function updateMessageHeader() {        
    $(".messageHeader").load("http://localhost/messenger/loadscripts/messenger_header.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading message header resulted in an error: ';
             console.log(msg + xhr.status + " " + xhr.statusText );
         }
          else {
            console.log('Updating message header');
        }
    });
};


function loadUsers() {        
    $("#userList").load("http://localhost/messenger/loadscripts/get_users_script.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading users resulted in an error: ';
            console.log(msg + xhr.status + " " + xhr.statusText );
        }
    });
};

/*
function chatWithUser() {
    $_SESSION['recipient_username'] = $user_array['username'];

};
*/