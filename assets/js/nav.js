/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function switchNavCss() {
    var x = document.getElementById("wp_TopNavMenu");
    if (x.className === "topNavMenu") {
        x.className += " mobile";
    } else {
        x.className = "topNavMenu";
    }
} 
