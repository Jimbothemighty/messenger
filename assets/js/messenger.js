//$(document).ready(function() {

/*  scrolls to the bottom of the message history div to ensure looking at the latest messages at the same time it gets the updated message list */
var add; // sets a global variable for use by callRefresh to set an interval
var bottom;  // (used in callRefresh.) TODO - figure out a way to make this action without the need for a Timeout. It's not the smoothest experience!

// on opening chat tab, load chat box fully
function callRefresh() {
    updateMessages();
    updateMessageHeader();
    updateMessageInput(); 
    var bottom = setTimeout(scrolltoBottom, 200);  // TODO - figure out a way to make this action without the need for a Timeout. It's not the smoothest experience!
    var add = setInterval(updateMessages, 10000);
}

// stops all updates of message history (interval) while not on chat tab
function stopRefresh() {
    clearInterval(add);
}

// updates chat message history regularly
function updateMessages() {        
    $(".messagehistory").load("loadscripts/messenger_script.php", function( response, status, xhr ) {
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
}

// updates chat header to display current user and recipient
function updateMessageHeader() {        
    $(".messageHeader").load("loadscripts/messenger_header.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading message header resulted in an error: ';
             console.log(msg + xhr.status + " " + xhr.statusText );
         }
          else {
            console.log('Updating message header');
        }
    });
}

// updates chat message writing box
function updateMessageInput() {        
    $(".messenger").load("loadscripts/messenger_input.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading message header resulted in an error: ';
             console.log(msg + xhr.status + " " + xhr.statusText );
         }
          else {
            console.log('Updating message input box');
        }
    });
}

// load user list into contacts tab
function loadUsers() {
    document.getElementById('searchLoadAnimation').style.display='block';
    $("#userList").load("loadscripts/get_users_script.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading users resulted in an error: ';
            console.log(msg + xhr.status + " " + xhr.statusText );
        }
        else {
            $("#searchLoadAnimation").css("display", "none");
        }
    });
}

// load user list into contacts tab
function loadConversations() {        
    $("#convoList").load("loadscripts/get_conversations_script.php", function( response, status, xhr ) {
        if ( status == "error" ) {
            var msg = 'Loading users resulted in an error: ';
            console.log(msg + xhr.status + " " + xhr.statusText );
        }
    });
}

// ajax to select recipient
function chatWithUser(x) {
var recipient = x;

$.ajax({
    type: 'post',
    url: 'loadscripts/messageAjax.php',
    data: {
        recipient_username:recipient,
    },
    success: function (response) {
    console.log('chatWithUser(): Updating Recipient...');
    }
});
document.getElementById("ccTab3").click();
callRefresh();
}

// pressing return/end submits message
function sendForm(e) {
//$('.message_textarea').keydown(function(e) {
//var keypress = e.which;
if (e.keyCode == 13) {
$('.message_form').submit();
}
};

// ajax to submit new messages
function submitdata() {
 var recipient = document.getElementById("recipient").value;
 var messagebody = document.getElementById("message_body").value;

 $.ajax({
  type: 'post',
  url: 'loadscripts/messageAjax.php',
  data: {
   recipient_username:recipient,
   message_textarea:messagebody,
  },
  success: function (response) {
    console.log('*****************submitData(): Now posting message.');
  },
  error: function (responsetwo) {
    console.log('*****************submitData(): Failed to post message.');
  }
 });
updateMessages();
}

// ajax to get search results by user
function searchUsers() {
var search_term = document.getElementById("searchTerm").value;
document.getElementById('searchLoadAnimation').style.display='block';

 $.ajax({
  type: 'post',
  url: 'loadscripts/searchUsersAjax.php',
  data: {
   searchTerm:search_term,
  },
  success: function (response) {
    console.log('Getting User search results.');
  },
  fail: function (responsetwo) {
    console.log('Its fucked!');
  }
 });
console.log('From searchUsers() ajax, search term = ', search_term);
document.getElementById('searchLoadAnimation').style.display='block';
setTimeout(loadUsers, 1000);
}

function submitSearch() {
    $( "#userList" ).empty();
    document.getElementById('searchLoadAnimation').style.display='block';
    searchUsers();
    $('.search_form')[0].reset();
}

// JQUERY DYNAMIC WINDOW RESIZING FOR MESSAGE HISTORY
function scrolltoBottom() {
    $(".ccContent").height($("body").height()-101);
    $(".messengerDetails").height($("body").height()-101);
    $(".messagehistory").height($(".messengerscript").height()-177);
    var a = document.getElementById("out");
    a.scrollTop = a.scrollHeight - a.clientHeight;
};
    jQuery(document).ready(function($) {
        scrolltoBottom();
        loadConversations();
        console.log('message history / script doc ready function running')
    });
    $(window).resize(function() {
        scrolltoBottom();
        console.log('message history / script window resize function running')
    });

